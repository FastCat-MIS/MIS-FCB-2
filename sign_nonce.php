<?php

// Script to sign a nonce with your private RSA key
// Usage: php sign_nonce.php <nonce> <path_to_private_key>

echo "🔐 PEM Nonce Signing Tool\n\n";

// Check command line arguments
if ($argc < 3) {
    echo "Usage: php sign_nonce.php <nonce> <path_to_private_key>\n";
    echo "Example: php sign_nonce.php 6d5e39d85d04abe846ec77f2be0dfe21 private_key.pem\n\n";
    exit(1);
}

$nonce = $argv[1];
$privateKeyPath = $argv[2];

echo "Nonce to sign: $nonce\n";
echo "Private key file: $privateKeyPath\n\n";

// Check if private key file exists
if (!file_exists($privateKeyPath)) {
    echo "❌ Error: Private key file not found: $privateKeyPath\n";
    echo "Please provide the path to your RSA private key file.\n";
    exit(1);
}

// Read private key
$privateKey = file_get_contents($privateKeyPath);

// Check if it's a valid private key
if (!str_contains($privateKey, '-----BEGIN PRIVATE KEY-----') &&
    !str_contains($privateKey, '-----BEGIN RSA PRIVATE KEY-----')) {
    echo "❌ Error: File does not appear to be a valid PEM private key\n";
    echo "Expected format: -----BEGIN PRIVATE KEY----- or -----BEGIN RSA PRIVATE KEY-----\n";
    exit(1);
}

// Load private key
$keyResource = openssl_pkey_get_private($privateKey);
if (!$keyResource) {
    echo "❌ Error: Invalid private key or passphrase required\n";
    echo "OpenSSL error: " . openssl_error_string() . "\n";
    exit(1);
}

// Sign the nonce
$signature = '';
$success = openssl_sign($nonce, $signature, $keyResource, OPENSSL_ALGO_SHA256);

if (!$success) {
    echo "❌ Error: Failed to sign nonce\n";
    echo "OpenSSL error: " . openssl_error_string() . "\n";
    exit(1);
}

// Base64 encode the signature
$base64Signature = base64_encode($signature);

echo "✅ Signature generated successfully!\n\n";

echo "📋 Copy this for your API request:\n";
echo "{\n";
echo "  \"pem_public_key\": \"-----BEGIN PUBLIC KEY-----\\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAlnQJOFWlu/IdgGEocS+D\\npYeWOJb93fo3b6xvex2A40qUbMQkLm8UZW9q7+IqNHHqT20s3/Lnt79H90RsSeaz\\n7z0kZAwjRB79IV0MhWeN+9G0fXhF7630qf/+Gnj7rAj/ra85G/k0707ZF04iLl1V\\n1Pt9WEVqp3lLskG9rbRlQEnDRnynUGyUFtDa8DIKSdGXSCXotQK+VUiedJIjlJLq\\n5krJ/06ZDPzhI5U/KRR0CPyZFGFuc9lZRvrEZWMy+23OuQIcTXtYLUPTGLpbYGNe\\nrapVm02oTY7EhXg9kuOgi5q8GZ6RVcENQqn5h84f52At2LXfk24O2aoRpdpFQc3G\\n0pJONYPy4MSaXYTt8n1TKlrGAdU0d39yJhanzNz9KrbDLW2kmfSGJm1HiD07cArO\\n71nkyqly0nMIa7FrCNsec+piCh86hokAnch/mhgeaW6r3i7L0SN/HVufwzLgw5X9\\nXbOoOMoBvc24wm/QJHiyCh+e6owfyUKONO22nSQLFvMEoZOD+8tcPXlBptGI0yCb\\njAq825+vHdqVV07oh20Yw/RtdxoBGXqqSMs9JEcTsEMR47yO4BsgVj9yZ7B9TeWx\\nqzNOHbPqA/8vnczGnOVSK3nfX8ZMuQCLFatafkUsAUaVD3H9HbSGj2g8CvgKMjkt\\n/mK5xZgoPrRi4JXQo6byM+kCAwEAAQ==\\n-----END PUBLIC KEY-----\",\n";
echo "  \"signature\": \"$base64Signature\",\n";
echo "  \"nonce\": \"$nonce\"\n";
echo "}\n\n";

echo "🚀 Ready to get your JWT token! Run:\n";
echo "curl -X POST http://localhost:8000/api/pem/token \\\n";
echo "  -H \"Content-Type: application/json\" \\\n";
echo "  -d '{\"pem_public_key\": \"YOUR_PUBLIC_KEY\", \"signature\": \"$base64Signature\", \"nonce\": \"$nonce\"}'\n";

// Clean up
openssl_free_key($keyResource);

?>
