Feature: Student attendance
    In order to have confidence that a students attendance is recorded
    As a user
    I want to submit an attendance record and verify it has saved

    Scenario: Submit an attended record for a student that does not exist without passing an api key
        When I submit an attendance record for a student with a matric number of "2" and they "have" attended and provide an api key of "invalid"
        Then The response should indicate I do not have access
        And The error should read "You are not authorised to perform this action"

    Scenario: Submit an attended record for a student that does not exist
        When I submit an attendance record for a student with a matric number of "2" and they "have" attended
        Then The response should indicate the student was not found
        And The error should read "Student was not found by matriculation number 2"

    # Duplicate test to ensure that the attended|unattended switch does not
    # do any weird side effects which might compromise integrity.
    Scenario: Submit an unattended record for a student that does not exist
        When I submit an attendance record for a student with a matric number of "2" and they "have not" attended
        Then The response should indicate the student was not found
        And The error should read "Student was not found by matriculation number 2"

    Scenario: Submit an attendance record for a student that does exist and verify
        Given The student with matriculation number "1" exists
        When I submit an attendance record for a student with a matric number of "1" and they "have not" attended
        Then the response should indicate it has been created
        And the database should have persisted the resulting attendance record