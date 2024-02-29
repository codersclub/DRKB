---
Title: Работа с сессиями
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Работа с сессиями
=================

Each function listed below returns information about a session or
performs a task that affects the session, such as starting a session or
adding a password.

DbiAddPassword
: Adds a password to the current session.

DbiCheckRefresh
: Checks for remote updates to tables for all cursors in the current
session, and refreshes the cursors if changed.

DbiCloseSession
: Closes the session associated with the given session handle.

DbiDropPassword
: Removes a password from the current session.

DbiGetCallBack
: Returns a pointer to the function previously registered by the client
for the given callback type.

DbiGetCurrSession
: Returns the handle associated with the current session.

DbiGetDateFormat
: Gets the date format for the current session.

DbiGetNumberFormat
: Gets the number format for the current session.

DbiGetSesInfo
: Retrieves the environment settings for the current session.

DbiGetTimeFormat
: Gets the time format for the current session.

DbiRegisterCallBack
: Registers a callback function for the client application.

DbiSetCurrSession
: Sets the current session of the client application to the session
associated with hSes.

DbiSetDateFormat
: Sets the date format for the current session.

DbiSetNumberFormat
: Sets the number format for the current session.

DbiSetPrivateDir
: Sets the private directory for the current session.

DbiSetTimeFormat
: Sets the time format for the current session.

DbiStartSession
: Starts a new session for the client application.

