---
Title: Конфигурация и настройка
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Конфигурация и настройка
========================

Each function listed below returns information about the client
application environment, such as the supported table, field and index
types for the driver type, or the available driver types. Functions in
this category can also perform tasks that affect the client application
environment, such as loading a driver.

DbiAddAlias
: Adds an alias to the BDE configuration file (IDAPI.CFG).

DbiAddDriver
: Adds a driver to the BDE configuration file (IDAPI.CFG).
NEW FUNCTION BDE 4.0

DbiAnsiToNative
: Multipurpose translate function.

DbiDebugLayerOptions
: Activates, deactivates, or sets options for the BDE debug layer.
OBSOLETE FUNCTION BDE 4.0

DbiDeleteAlias
: Deletes an alias from the BDE configuration file (IDAPI.CFG).

DbiDeleteDriver
: Deletes a driver from the BDE configuration file (IDAPI.CFG).
NEW FUNCTION BDE 4.0

DbiDllExit
: Prepares the BDE to be disconnected within a DLL.
NEW FUNCTION BDE 4.0

DbiExit
: Disconnects the client application from BDE.

DbiGetClientInfo
: Retrieves system-level information about the client application
environment.

DbiGetDriverDesc
: Retrieves a description of a driver.

DbiGetLdName
: Retrieves the name of the language driver associated with the specified
object name (table name).

DbiGetLdObj
: Retrieves the language driver object associated with the given cursor.

DbiGetNetUserName
: Retrieves the user\'s network login name. User names should be available
for all networks supported by Microsoft Windows.

DbiGetProp
: Returns a property of an object.

DbiGetSysConfig
: Retrieves BDE system configuration information.

DbiGetSysInfo
: Retrieves system status and information.

DbiGetSysVersion
: Retrieves the system version information, including the BDE version
number, date, and time, and the client interface version number.

DbiInit
: Initializes the BDE environment.

DbiLoadDriver
: Load a given driver.

DbiNativeToAnsi
: Translates a string in the native language driver to an ANSI string.

DbiOpenCfgInfoList
: Returns a handle to an in-memory table listing all the nodes in the
configuration file accessible by the specified path.

DbiOpenDriverList
: Creates an in-memory table containing a list of driver names available
to the client application.

DbiOpenFieldTypesList
: Creates an in-memory table containing a list of field types supported by
the table type for the driver type.

DbiOpenFunctionArgList
: Returns a list of arguments to a data source function.

DbiOpenFunctionList
: Returns a description of a data source function.

DbiOpenIndexTypesList
: Creates an in-memory table containing a list of all supported index
types for the driver type.

DbiOpenLdList
: Creates an in-memory table containing a list of available language
drivers.

DbiOpenTableList
: Creates an in-memory table with information about all the tables
accessible to the client application.

DbiOpenTableTypesList
: Creates an in-memory table listing table type names for the given
driver.

DbiOpenUserList
: Creates an in-memory table containing a list of users sharing the same
network file.

DbiSetProp
: Sets the specified property of an object to a given value.

DbiUseIdleTime
: Allows BDE to accomplish background tasks during times when the client
application is idle.
OBSOLETE FUNCTION BDE 4.0

