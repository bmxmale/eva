# First Visa Application


### Endpoint
<code-block lang="curl">POST /application</code-block>

#### Body
<code-block lang="json">
{
  "passport": {
    "number": "YUBICO2025",
    "code": "USA",
    "type": "P",
    "firstName": "John",
    "lastName": "Wick",
    "issuedAt": "2021-06-01",
    "expiresAt": "2031-06-01"
  },
  "visaType": "D",
  "purposeOfVisit": 4,
  "startDate": "2025-01-01",
  "endDate": "2035-12-31",
  "status": "approved"
}
</code-block>

#### Response

<code-block lang="json">
{
    "@context": "/contexts/Application",
    "@id": "/applications/1",
    "@type": "Application",
    "id": 1,
    "passport": {
        "@id": "/passport/USA/YUBICO2025",
        "@type": "Passport",
        "number": "YUBICO2025"
    },
    "visaType": "D",
    "purposeOfVisit": 4,
    "startDate": "2025-01-01T00:00:00+00:00",
    "endDate": "2035-12-31T00:00:00+00:00",
    "status": "approved",
    "valid": true
}
</code-block>
