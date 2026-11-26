## Title
Sijukir Dishub Blueprint Alignment: parking-first scope, tax-domain cleanup, and access/reporting consistency

## Description

### Summary
This PR aligns the Sijukir project to the Dishub blueprint by narrowing the scope to parking operations and related revenue management, while removing legacy tax-domain logic that is outside Dishub authority.

### What changed
- removed legacy Pajak Parkir and Wajib Pajak references from routes, controllers, views, validation, and database seeds
- cleaned revenue object rules to support only Dishub-appropriate object types
- restricted master-data access to admin while keeping dashboard and operational flows available to admin, operator, and pimpinan
- kept support modules such as asset utilization and unit business management separated from the core parking flow
- aligned dashboard and reporting logic with verified operational data
- preserved audit logging and operational integrity checks

### Scope
In scope:
- parking master data and operations
- revenue sources and objects relevant to Dishub processes
- parking targets, achievement tracking, and reporting
- asset utilization support modules

Out of scope:
- Wajib Pajak
- Pajak Parkir
- tax object management
- NPWP/NOP/tax calculation logic
- any business process outside Dishub authority

### Verification
- verified with relevant feature tests covering access control and revenue integrity
- result: 30 passed, 100 assertions

---

## Notes for reviewers
- the project scope is intentionally parking-first and Dishub-specific
- legacy tax logic was removed to reduce drift from the blueprint
- support modules remain separate from the main parking flow
- access control is aligned with the intended operational model
