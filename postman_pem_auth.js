// Postman PEM Authentication Automation
// Save this as a Pre-request Script for your PEM auth requests

// Configuration - Update these values for your environment
const privateKeyPem = `-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC...
-----END PRIVATE KEY-----`;

const publicKeyPem = `-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA...
-----END PUBLIC KEY-----`;

const baseUrl = 'http://localhost:8000';

// Generate SHA256 signature using Web Crypto API
async function generateSignature(data, privateKeyPem) {
    try {
        // Convert PEM to JWK format
        const pemHeader = '-----BEGIN PRIVATE KEY-----';
        const pemFooter = '-----END PRIVATE KEY-----';
        const pemContents = privateKeyPem
            .replace(pemHeader, '')
            .replace(pemFooter, '')
            .replace(/\s/g, '');
        
        const binaryDer = atob(pemContents);
        const binaryDerArray = new Uint8Array(binaryDer.length);
        for (let i = 0; i < binaryDer.length; i++) {
            binaryDerArray[i] = binaryDer.charCodeAt(i);
        }
        
        // Import private key
        const privateKey = await crypto.subtle.importKey(
            'pkcs8',
            binaryDerArray,
            {
                name: 'RSASSA-PKCS1-v1_5',
                hash: 'SHA-256',
            },
            false,
            ['sign']
        );
        
        // Sign the data
        const encoder = new TextEncoder();
        const dataBuffer = encoder.encode(data);
        
        const signature = await crypto.subtle.sign(
            'RSASSA-PKCS1-v1_5',
            privateKey,
            dataBuffer
        );
        
        // Convert to base64
        return btoa(String.fromCharCode(...new Uint8Array(signature)));
        
    } catch (error) {
        console.error('Signature generation failed:', error);
        throw error;
    }
}

// Main authentication function
async function pemAuth() {
    try {
        console.log('Starting PEM authentication...');
        
        // Step 1: Get nonce
        const nonceResponse = await pm.sendRequest({
            url: `${baseUrl}/pem/nonce`,
            method: 'GET'
        });
        
        const nonce = nonceResponse.json().nonce;
        console.log('Got nonce:', nonce);
        
        // Step 2: Generate signature
        console.log('Generating signature...');
        const signature = await generateSignature(nonce, privateKeyPem);
        console.log('Signature generated');
        
        // Step 3: Get JWT token
        const tokenResponse = await pm.sendRequest({
            url: `${baseUrl}/pem/token`,
            method: 'POST',
            header: {
                'Content-Type': 'application/json'
            },
            body: {
                mode: 'raw',
                raw: JSON.stringify({
                    pem_public_key: publicKeyPem,
                    signature: signature,
                    nonce: nonce
                })
            }
        });
        
        const tokenData = tokenResponse.json();
        const jwtToken = tokenData.data.access_token.replace('Bearer ', '');
        
        console.log('JWT token obtained');
        
        // Store token in environment
        pm.environment.set('pem_jwt_token', jwtToken);
        pm.environment.set('pem_token_timestamp', new Date().toISOString());
        
        return jwtToken;
        
    } catch (error) {
        console.error('PEM authentication failed:', error);
        throw error;
    }
}

// Check if we need to refresh token
function shouldRefreshToken() {
    const tokenTimestamp = pm.environment.get('pem_token_timestamp');
    if (!tokenTimestamp) return true;
    
    const tokenAge = new Date() - new Date(tokenTimestamp);
    return tokenAge > 3000000; // Refresh if older than 50 minutes (5 min before expiry)
}

// Main execution
if (shouldRefreshToken() || !pm.environment.get('pem_jwt_token')) {
    console.log('Token needs refresh, starting authentication...');
    pemAuth()
        .then(token => {
            console.log('Authentication successful');
            // Set Authorization header for the current request
            pm.request.headers.upsert({
                key: 'Authorization',
                value: `Bearer ${token}`
            });
        })
        .catch(error => {
            console.error('Authentication error:', error);
            // You might want to handle this differently
            throw error;
        });
} else {
    console.log('Using cached token');
    const token = pm.environment.get('pem_jwt_token');
    pm.request.headers.upsert({
        key: 'Authorization',
        value: `Bearer ${token}`
    });
}