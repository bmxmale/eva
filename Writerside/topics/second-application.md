# Seconnd Visa Application


### Endpoint
<code-block lang="curl">POST /application</code-block>

#### Body
<code-block lang="json">
{
    "visaType": "C",
    "purposeOfVisit": 3,
    "startDate": "2025-11-01",
    "endDate": "2025-11-30",
    "status": "pending",
    "passport": "/passport/USA/YUBICO2025"
}
</code-block>

#### Response

<code-block lang="json">
{
    "@context": "/contexts/Application",
    "@id": "/applications/2",
    "@type": "Application",
    "id": 2,
    "passport": {
        "@id": "/passport/USA/YUBICO2025",
        "@type": "Passport",
        "number": "YUBICO2025"
    },
    "visaType": "C",
    "purposeOfVisit": 3,
    "startDate": "2025-11-01T00:00:00+00:00",
    "endDate": "2025-11-30T00:00:00+00:00",
    "status": "pending",
    "valid": false
}
</code-block>
