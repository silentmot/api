# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [1.17.4] - 2021-12-02
### Changed
- Removed `qr_code` required validation in permissions creation.

## [1.17.3] - 2021-07-13
### Added
- Added permission logs.


## [1.17.2] - 2021-06-28
### Fixed
- Fixed Masader integration.


## [1.17.1] - 2021-06-24
### Changed
- Changed `masader` integration to push transaction info after the trip ended instead of pull all transactions in one request.


## [1.17.0] - 2021-04-11
### Changed
- Enabled unit entrance by the `QR` code.


## [1.17.0] - 2021-04-11
### Changed
- Sending the `enterance` and `exit` transactions to CAP only in exit action.


## [1.16.2] - 2020-07-19
### added
- violation report.


## [1.16.1] - 2020-07-16
### added
- station report.


## [1.15.1] - 2020-07-04
### added
- per hour report.
- refactor some responses in workflow.


## [1.14.3] - 2020-06-24
### added
- Districts report.
- Contractors report.
- Waste types report.


## [1.13.2] - 2020-06-12
### added
- Mardam Workflow.
- Units report.

### changed
- Dashboard charts to get data from new workflow tables.
- Permission view query.


## [1.2.3] - 2020-04-01
### added
-export transitional station
-show transitional station


## [1.2.2] - 2020-04-01
### added
- Update transitional station
- delete transitional station
- delete many transitional station
- transitional station seed


## [1.2.1] - 2020-04-01
### added
- Add station field to create contract from
- Add station field to update contract from
- Add districts filter to transitional station list endpoint
- Edit un-contracted units endpoint to get all units


## [1.2.0] - 2020-03-30
### added
-store transitional station
-list transitional station
-permissions for module
- active filter


## [1.1.15] - 2020-03-11
### added
- zones to waste types


## [1.1.14] - 2020-03-10
### added
- Integration Workflow migrations
- CAP integration
- Permissions documentation

### Fixed
- permission_number type
- Entrance permission update validation


## [1.1.13] - 2020-03-09
### Fixed
- add more than two mobile numbers to each contact person in contractor
- The Contractor Name English field shouldn't accept numeric values
- The password length should accept password greater than 10 letters
- The Commercial Registration number field should be unique Edit in Contractor
- The permission number should be numeric only in all permissions types
- The user should be able to sort by status

## [1.1.12] - 2020-03-08
### added
- avl company to contractor module


## [1.1.11] - 2020-03-03
### added
- District update

### Fixed
- The dashbord permission should be one not two
- Edit Profile The minimum length of password should be 8 letters
- The role of the admin "owner" user shouldn't be editable
- Can't sort by geofences value (zone/pit)
- The "Username " field shouldn't accept spaces
- Reformat the contract number in the units report
- Reformat the contract number in the Contract exported sheet


## [1.1.10] - 2020-03-02
### added
- District create


## [1.1.9] - 2020-03-02
### fixed
- User module issues.


## [1.1.8] - 2020-03-02
### added
- District delete

### changed
- District list


## [1.1.7] - 2020-02-25
### added
- users list unit test cases
- show user profile test cases

### Removed
- users email and username unique key
- search with type in enternace permissions


## [1.1.6] - 2020-02-24
### Fixed
- Validate format the email in "Forget Password"
- Delete Many deactivated contracts
- show only active units in contract related to current contractor



## [1.1.5] - 2020-02-20
### Added
- Delete roles
- Roles effects modules
- User permissions endpoint


## [1.1.4] - 2020-02-20
### Added
- update roles

### Fixed
- Fix GivenModulesAvailable rule.


## [1.1.3] - 2020-02-19
### Added
- Store roles


## [1.1.2] - 2020-02-19
### Fixed
- update status in users
- update id and type in geofences


## [1.1.2] - 2020-02-19
### Changed
- phone users seed
- role in update profile into id and name

### Fixed
- show user data

### Added
- Add geofences
- show geofences
- list geofences
- export geofences
- update geofences
- delete geofences
- delete many geofences


## [1.1.1] - 2020-02-17
### Changed
- list users
- login active user only

### Added
- Add User
- update user
- show
- delete user
- delete many user


## [1.1.0] - 2020-02-17
### Changed
- Role list.

### Added
- Create Role show.
- Create permission list.


## [0.3.28] - 2020-02-12
### Fixed
- update vin number in units to be null when it is not mandatory.


## [0.3.26] - 2020-02-10
### Added
- Adding Contract Number in the Add and Edit Contract Form.


## [0.3.25] - 2020-02-07
### Fixed
- unit types duplicated in list


## [0.3.24] - 2020-02-06
### Added
- National ID should be start with "1" or "2" in entrance permissions


## [0.3.23] - 2020-02-05
### Fixed
- unit types with deleted unit not listed
- unit counts in districts counted despite it is deleted
- unit counts in contracts counted despite it is deleted


## [0.3.22] - 2020-02-04
### Fixed
- waste types with deleted unit not listed


## [0.3.21] - 2020-02-04
### Changed
- demolition serial and permission number into string


## [0.3.20] - 2020-02-03
### Fixed
- National ID should be start with "1" or "2"


## [0.3.19] - 2020-02-03
### Changed
- Disabling the user to change the contractor name in unit


## [0.3.18] - 2020-02-02
### Changed
- Changing VIN Number to a non Mandatory field with length 50.
- Changing Employees to a non Mandatory field
- Changing Model to a non Mandatory field


## [0.3.17] - 2020-02-02
### Removed
- remove search by date from entrance permissions


## [0.3.16] - 2020-01-30
### Added
- delete entrance permissions


## [0.3.15] - 2020-01-29
### Added
- update entrance permissions

## [0.3.14] - 2020-01-29
### Added
- show entrance permissions


## [0.3.13] - 2020-01-29
### Added
- create entrance permissions
- list entrance permissions
- export list entrance permissions
- cast phone number in individual permission


## [0.3.12] - 2020-01-27
### Added
- show all types of permissions

## [0.3.12] - 2020-01-22
### Added
- Creating Contracts Report in Dashboard
- Creating Waste Types Report in Dashboard


## [0.3.11] - 2020-01-22
### Added
- Creating District Report in Dashboard


## [0.3.10] - 2020-01-22
### Added
- create governmental damaged  permission
- create commercial damaged  permission
- create append units APIs

### Fixed
- date format in show
- seed data neighbourhood and districts


## [0.3.9] - 2020-01-21
### Added
- Creating Units Report in Dashboard
- Creating Waste weights per Hour Report in Dashboard


## [0.3.8] - 2020-01-20
### Added
- create damaged projects permission
- list damaged project demolition serial
- show individual damaged permission
- show damaged projects permission


## [0.3.7] - 2020-01-20
### Added
- store individual permission
- list individual permission demolition serial API


## [0.3.6] - 2020-01-20
### Added
- dashboard system total information.
- dashboard yesterday total information.
- dashboard contractors information today.
- dashboard waste types information today.
- dashboard today weight count per hour.
- dashboard last week total  weights.


## [0.3.5] - 2020-01-19
### Added
- seed for all types of Permission


## [0.3.4] - 2020-01-19
### Fixed
- Make contractor address not mandatory


## [0.3.3] - 2020-01-15
### Added
- Update APIs in swagger


## [0.3.2] - 2020-01-14
### Added
- Set Permission database architecture.
- Add new waste types.
- Refactor added waste types.


## [0.3.1] - 2020-01-14
### Added
- AVLs integration API.

### Changed
- Refactor ZK module.


## [0.2.31] - 2020-01-14
### Added
- Laravel Telescope.
- Sentry.


## [0.2.30] - 2020-01-12
### Fixed
- CC-246
- CC-242
- CC-247


## [0.2.29] - 2020-01-09
### Changed
- all data transfer object extend from flexible class


## [0.2.28] - 2020-01-08
### Removed
- Unique contact name validation


## [0.2.27] - 2020-01-07
### Fixed
- change failed contractor message


## [0.2.26] - 2020-01-07
### Fixed
- arabic character pattern can has multiple spaces


## [0.2.25] - 2020-01-07
### Fixed
- only one Contractor is default


## [0.2.24] - 2020-01-06
### Added
- Update Contract


## [0.2.23] - 2020-01-06
### Added
- Contractor Update


## [0.2.22] - 2020-01-06
### Fixed
- adjust seed in contracts


## [0.2.21] - 2020-01-05
### Added
- Contract delete.


## [0.2.20] - 2020-01-04
### Added
- Contract show.
- Contract store.


## [0.2.19] - 2020-01-03
### fixed
-sort unit type name and net weight in units table.
-many delete in contractors table.


## [0.2.19] - 2020-01-03
### Added
- Un-contracted units for contractors on `contractors/:id/uncontracted-units` URL.
- Un-contracted neighborhoods for districts on `districts/:id/uncontracted-neighborhoods` URL.

### fixed
- RFID columns length in units table.


## [0.2.18] - 2020-01-03
### Added
- Delete Single Contractor.
- Delete Many Contractor.


## [0.2.17] - 2020-01-02
### fixed
- validation for email format , employees to be integer, contact name not unique , make commerical number unique, one default contact.


## [0.2.16] - 2020-01-01
### Added
- Create Contractor with contacts and their phones.


## [0.2.15] - 2019-12-31
### Added
- Contract seed.

### Changed
- Mardam seeds.


## [0.2.14] - 2019-12-31
### Added
- List Contractors.
- export Contractors.
- Show Contractors.


## [0.2.13] - 2019-12-31
### Fixed
- Unit weight validation.


## [0.2.12] - 2019-12-30
### Removed
- Remove Ton Validation from Units.


## [0.2.11] - 2019-12-29
### Added
- Empty check for unit deletion.

### Changed
- Unit weight type to double.


## [0.2.10] - 2019-12-25
### changed
- Excel sheets direction to RTL.


## [0.2.9] - 2019-12-24
### changed
- validation messages for reset passwords.


## [0.2.8] - 2019-12-24
### changed
- validation messages into arabic.


## [0.2.7] - 2019-12-24
### Fixed
- Waste type and profile issues.


## [0.2.6] - 2019-12-24
### Added
- Units count in unit types and waste types modules .


## [0.2.5] - 2019-12-24
### Added
- Delete units.

### Fixed
- Waste type validation.


## [0.2.4] - 2019-12-24
### Fixed
- Export Devices Data as Upper case.


## [0.2.3] - 2019-12-24
### Added
- Update units.


## [0.2.2] - 2019-12-24
### Added
- Store units.


## [0.2.1] - 2019-12-23
### Added
- Unit list.
- Unit Export.
- Unit Show.


## [0.1.35] - 2019-12-23
### Added
- Update Unit Type.


## [0.1.34] - 2019-12-23
### Added
- delete unit type.
- delete multi unit types.


## [0.1.33] - 2019-12-23
### Changed
- Login response and add user full-name.


## [0.1.32] - 2019-12-23
### Fixed
- Old password be require with password.


## [0.1.31] - 2019-12-23
### Added
- Unit module with seed.


## [0.1.30] - 2019-12-22
### Added
- create unit type.
- list unit type.
- export list unit type.
- unit tests for list,export and show unit type.


## [0.1.29] - 2019-12-19
### Changed
- avatar deletion in user profile.
- password complexity.


## [0.1.28] - 2019-12-19
### Changed
- UAT deployment configurations.


## [0.1.27] - 2019-12-19
### Added
- Dummy endpoints for ZK.


## [0.1.26] - 2019-12-19
### Changed
- remove authentication from image.


## [0.1.25] - 2019-12-19
### Changed
- Zone, Devices, Gate, Scales data into arabic.


## [0.1.24] - 2019-12-18
### Added
- delete waste type.
- delete many waste types.


## [0.1.22] - 2019-12-18
### Added
- update waste types.


## [0.1.21] - 2019-12-18
### Added
- store waste types.


## [0.1.21] - 2019-12-18
### Fixed
- Gate search for name and serial.


## [0.1.20] - 2019-12-18
### Added
- List waste types.
- Export waste types.
- Show waste type.


## [0.1.19] - 2019-12-17
### Fixed
- Gate transformer to translate directions.


## [0.1.18] - 2019-12-16
### Added
- List Devices.
- Export Devices.


## [0.1.17] - 2019-12-16
### Added
- List Zones.
- Export Zones.


## [0.1.16] - 2019-12-16
### Added
- List Gates.
- Export Gates.


## [0.1.15] - 2019-12-16
### Added
- Seed for zone modules.


## [0.1.14] - 2019-12-15
### Added
- List Scales.
- Export Scales.


## [0.1.13] - 2019-12-12
### Changed
- Sort by username to full name in user list.


## [0.1.12] - 2019-12-12
### Added
- Show User Profile.
- Update User Profile.


## [0.1.11] - 2019-12-10
### Changed
- Gitlab CI file.


## [0.1.10] - 2019-12-10
### Changed
- development deploy Envoy file.


## [0.1.9] - 2019-12-10
### Added
- Role export.


## [0.1.8] - 2019-12-09
### Added
- Role list.


## [0.1.7] - 2019-12-09
### Changed
- Request classes names.


## [0.1.6] - 2019-12-09
### Fixed
- Camel case response.


## [0.1.5] - 2019-12-09
### Added
- Get export Users list API `/users/export` .


## [0.1.4] - 2019-12-08
### Added
- Get User list API `/users` .


## [0.1.3] - 2019-12-08
### Added
- District list and export.


## [0.1.2] - 2019-12-05
### Added
- Incomplete tests to Auth operations.


## [0.1.1] - 2019-12-04
### Added
- Login.
- Logout.
- Forget password.
- Reset password.


## [0.1.0] - 2019-12-02
### Added
- Afaqy core.
