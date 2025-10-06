# Get Applications for passport

### Endpoint
<code-block lang="curl">GET /applications/{code}/{number}</code-block>

#### Example:

<code-block lang="curl">GET /applications/USA/YUBICO2025</code-block>

#### Response

<code-block lang="json">
{
    "@context": "/contexts/Application",
    "@id": "/applications/USA/YUBICO2025",
    "@type": "Collection",
    "totalItems": 2,
    "member": [
        {
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
        },
        {
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
    ]
}
</code-block>
