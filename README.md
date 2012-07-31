# SimplePush

To create a push, export both the private an public key as server_certificates_bundle[_sandbox].p12

    openssl pkcs12 -in server_certificates_bundle_sandbox.p12 -out server_certificates_bundle_sandbox.pem -nodes -clcerts
