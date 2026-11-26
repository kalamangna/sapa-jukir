## PR untuk Tim Developer / Reviewer

### Context
The project was drifting from the Dishub blueprint by retaining tax-related concepts such as Pajak Parkir and Wajib Pajak. This PR re-aligns the application to the intended scope: parking operations and Dishub-relevant revenue management.

### Changes
- removed legacy tax references from routes, views, validation, and seed data
- removed Wajib Pajak / tax-object assumptions from revenue object logic
- narrowed object type options to valid Dishub-relevant values
- corrected role-based access so master data stays admin-only while operational flows remain available to admin/operator/pimpinan
- cleaned dashboard and reporting logic to match verified operational data
- kept asset utilization and unit business flows as support modules without tax coupling

### Validation
Command used:
`cd c:/xampp/htdocs/sijukir-sinjai ; php artisan test --filter='AccessControlTest|RevenueIntegrityTest'`

Result:
- 30 passed
- 100 assertions
- exit code 0

### Review focus
- confirm scope matches Dishub blueprint
- ensure no tax logic remains in routes/views/validation
- confirm support modules remain distinct from core parking flow
- verify access policy still matches intended roles
