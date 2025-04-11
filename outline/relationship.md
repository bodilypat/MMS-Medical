users ─┬─> medical_records
       └─> prescriptions

patients ─┬─> appointments ──┬─> doctors
          │                 ├─> medical_records
          │                 ├─> lab_tests
          │                 └─> payments
          ├─> prescriptions (via medical_records)
          ├─> insurance
          └─> lab_tests

medical_records ──> prescriptions

pharmacies (optional link to prescriptions)

insurance ──> patients