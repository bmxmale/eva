# Get Passport

### Endpoint
<code-block lang="curl">GET /passport/{code}/{number}</code-block>

#### Example:

<code-block lang="curl">GET /passport/USA/YUBICO2025</code-block>

#### Response

<code-block lang="json">
{
    "@context": "/contexts/Passport",
    "@id": "/passport/USA/YUBICO2025",
    "@type": "Passport",
    "number": "YUBICO2025",
    "code": "USA",
    "type": "P",
    "firstName": "John",
    "lastName": "Wick",
    "issuedAt": "2021-06-01T00:00:00+00:00",
    "expiresAt": "2031-06-01T00:00:00+00:00",
    "valid": true
}
</code-block>
