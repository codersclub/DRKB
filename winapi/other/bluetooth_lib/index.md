---
Title: Библиотека для работы с Bluetooth
Date: 12.12.2006
Author: Mike B. Petrichenko, pmb_stv@mail.ru
---


Библиотека для работы с Bluetooth
=================================

    package BTClasses;
     
    {$R *.res}
    {$ALIGN 8}
    {$ASSERTIONS ON}
    {$BOOLEVAL OFF}
    {$DEBUGINFO ON}
    {$EXTENDEDSYNTAX ON}
    {$IMPORTEDDATA ON}
    {$IOCHECKS ON}
    {$LOCALSYMBOLS ON}
    {$LONGSTRINGS ON}
    {$OPENSTRINGS ON}
    {$OPTIMIZATION ON}
    {$OVERFLOWCHECKS OFF}
    {$RANGECHECKS OFF}
    {$REFERENCEINFO ON}
    {$SAFEDIVIDE OFF}
    {$STACKFRAMES OFF}
    {$TYPEDADDRESS OFF}
    {$VARSTRINGCHECKS ON}
    {$WRITEABLECONST OFF}
    {$MINENUMSIZE 1}
    {$IMAGEBASE $400000}
    {$IMPLICITBUILD OFF}
     
    requires
      rtl;
     
    contains
      BTRadio in 'BTRadio.pas',
      BluetoothAPI in 'BluetoothAPI.pas',
      BthSdpDef in 'BthSdpDef.pas',
      BTExceptions in 'BTExceptions.pas',
      BTStrings in 'BTStrings.pas',
      BTDevice in 'BTDevice.pas';
     
    end.

    unit BluetoothAPI;
     
    interface
     
    uses
      Windows, BthSdpDef;
     
    const
      BLUETOOTH_MAX_NAME_SIZE            = 248;
      {$EXTERNALSYM BLUETOOTH_MAX_NAME_SIZE}
      BLUETOOTH_MAX_PASSKEY_SIZE         = 16;
      {$EXTERNALSYM BLUETOOTH_MAX_PASSKEY_SIZE}
      BLUETOOTH_MAX_PASSKEY_BUFFER_SIZE  = BLUETOOTH_MAX_PASSKEY_SIZE + 1;
      {$EXTERNALSYM BLUETOOTH_MAX_PASSKEY_BUFFER_SIZE}
     
    // ***************************************************************************
    //
    //  Bluetooth Address
    //
    // ***************************************************************************
     
    type
      BTH_ADDR = Int64;
      {$EXTERNALSYM BTH_ADDR}
     
      _BLUETOOTH_ADDRESS = record
        case Integer of
          0: (ullLong: BTH_ADDR);       //  easier to compare again BLUETOOTH_NULL_ADDRESS
          1: (rgBytes: array [0..5] of Byte); //  easier to format when broken out
      end;
      {$EXTERNALSYM _BLUETOOTH_ADDRESS}
      BLUETOOTH_ADDRESS = _BLUETOOTH_ADDRESS;
      {$EXTERNALSYM BLUETOOTH_ADDRESS}
      TBlueToothAddress = BLUETOOTH_ADDRESS;
      PBlueToothAddress = ^BLUETOOTH_ADDRESS;
     
    const
      BLUETOOTH_NULL_ADDRESS: TBlueToothAddress = (ullLong: 0;);
      {$EXTERNALSYM BLUETOOTH_NULL_ADDRESS}
     
    // ***************************************************************************
    //
    //  Radio Enumeration
    //
    //  Description:
    //      This group of APIs enumerates the installed Bluetooth radios.
    //
    //  Sample Usage:
    //      HANDLE hRadio;
    //      BLUETOOTH_FIND_RADIO_PARAMS btfrp = { sizeof(btfrp) };
    //
    //      HBLUETOOTH_RADIO_FIND hFind = BluetoothFindFirstRadio( &btfrp, &hRadio );
    //      if ( NULL != hFind )
    //      {
    //          do
    //          {
    //              //
    //              //  TODO: Do something with the radio handle.
    //              //
    //
    //              CloseHandle( hRadio );
    //
    //          } while( BluetoothFindNextRadio( hFind, &hRadio ) );
    //
    //          BluetoothFindRadioClose( hFind );
    //      }
    //
    // ***************************************************************************
     
    type
      _BLUETOOTH_FIND_RADIO_PARAMS = record
        dwSize: DWORD;             //  IN  sizeof this structure
      end;
      {$EXTERNALSYM _BLUETOOTH_FIND_RADIO_PARAMS}
      BLUETOOTH_FIND_RADIO_PARAMS = _BLUETOOTH_FIND_RADIO_PARAMS;
      {$EXTERNALSYM BLUETOOTH_FIND_RADIO_PARAMS}
      TBlueToothFindRadioParams = BLUETOOTH_FIND_RADIO_PARAMS;
      PBlueToothFindRadioParams = ^BLUETOOTH_FIND_RADIO_PARAMS;
     
      HBLUETOOTH_RADIO_FIND = THandle;
      {$EXTERNALSYM HBLUETOOTH_RADIO_FIND}
     
    //
    //  Description:
    //      Begins the enumeration of local Bluetooth radios.
    //
    //  Parameters:
    //      pbtfrp
    //          A pointer to a BLUETOOTH_FIND_RADIO_PARAMS structure.
    //          The dwSize member of this structure must match the sizeof
    //          the of the structure.
    //
    //      phRadio
    //          A pointer where the first radio HANDLE enumerated will be returned.
    //
    //  Return Values:
    //      NULL
    //          Error opening radios or no devices found.
    //          Use GetLastError() for more info.
    //
    //          ERROR_INVALID_PARAMETER
    //              pbtfrp parameter is NULL.
    //
    //          ERROR_REVISION_MISMATCH
    //              The pbtfrp structure is not the right length.
    //
    //          ERROR_OUTOFMEMORY
    //              Out of memory.
    //
    //          other Win32 errors.
    //
    //      any other
    //          Success. The return handle is valid and phRadio points to a valid handle.
    //
     
    function BluetoothFindFirstRadio(const pbtfrp: PBlueToothFindRadioParams; var phRadio: THandle):
             HBLUETOOTH_RADIO_FIND; stdcall;
    {$EXTERNALSYM BluetoothFindFirstRadio}
     
    //
    //  Description:
    //      Finds the next installed Bluetooth radio.
    //
    //  Parameters:
    //      hFind
    //          The handle returned by BluetoothFindFirstRadio().
    //
    //      phRadio
    //          A pointer where the next radio HANDLE enumerated will be returned.
    //
    //  Return Values:
    //      TRUE
    //          Next device succesfully found. pHandleOut points to valid handle.
    //
    //      FALSE
    //          No device found. pHandleOut points to an invalid handle. Call
    //          GetLastError() for more details.
    //
    //          ERROR_INVALID_HANDLE
    //              The handle is NULL.
    //
    //          ERROR_NO_MORE_ITEMS
    //              No more radios found.
    //
    //          ERROR_OUTOFMEMORY
    //              Out of memory.
    //
    //          other Win32 errors
    //
     
    function BluetoothFindNextRadio(hFind: HBLUETOOTH_RADIO_FIND; var phRadio: THandle):
             BOOL; stdcall;
    {$EXTERNALSYM BluetoothFindNextRadio}
     
    //
    //  Description:
    //      Closes the enumeration handle.
    //
    //  Parameters
    //      hFind
    //          The handle returned by BluetoothFindFirstRadio().
    //
    //  Return Values:
    //      TRUE
    //          Handle succesfully closed.
    //
    //      FALSE
    //          Failure. Check GetLastError() for details.
    //
    //          ERROR_INVALID_HANDLE
    //              The handle is NULL.
    //
     
    function BluetoothFindRadioClose(hFind: HBLUETOOTH_RADIO_FIND): BOOL; stdcall;
    {$EXTERNALSYM BluetoothFindRadioClose}
     
    // ***************************************************************************
    //
    //  Radio Information
    //
    // ***************************************************************************
     
    type
      _BLUETOOTH_RADIO_INFO = record
        dwSize: DWORD;               // Size, in bytes, of this entire data structure
        address: BLUETOOTH_ADDRESS;  // Address of the local radio
        szName: array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of WideChar; // Name of the local radio
        ulClassofDevice: ULONG;      // Class of device for the local radio
        lmpSubversion: Word;         // lmpSubversion, manufacturer specifc.
        manufacturer: Word;          // Manufacturer of the radio, BTH_MFG_Xxx value.
                                     // For the most up to date list,
                                     // goto the Bluetooth specification website
                                     // and get the Bluetooth assigned numbers document.
      end;
      {$EXTERNALSYM _BLUETOOTH_RADIO_INFO}
      BLUETOOTH_RADIO_INFO = _BLUETOOTH_RADIO_INFO;
      {$EXTERNALSYM BLUETOOTH_RADIO_INFO}
      PBLUETOOTH_RADIO_INFO = ^BLUETOOTH_RADIO_INFO;
      {$EXTERNALSYM PBLUETOOTH_RADIO_INFO}
      TBlueToothRadioFind = BLUETOOTH_RADIO_INFO;
      PBlueToothRadioFind = PBLUETOOTH_RADIO_INFO;
     
    //
    //  Description:
    //      Retrieves the information about the radio represented by the handle.
    //
    //  Parameters:
    //      hRadio
    //          Handle to a local radio retrieved through BluetoothFindFirstRadio()
    //          et al or SetupDiEnumerateDeviceInterfaces()
    //
    //      pRadioInfo
    //          Radio information to be filled in.
    //          The dwSize member must match the size of the structure.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The information was retrieved successfully.
    //
    //      ERROR_INVALID_PARAMETER
    //          pRadioInfo or hRadio is NULL.
    //
    //      ERROR_REVISION_MISMATCH
    //          pRadioInfo->dwSize is invalid.
    //
    //      other Win32 error codes.
    //
     
    function BluetoothGetRadioInfo(hRadio: THandle; var pRadioInfo: BLUETOOTH_RADIO_INFO):
             DWORD; stdcall;
    {$EXTERNALSYM BluetoothGetRadioInfo}
     
    // ***************************************************************************
    //
    //  Device Information Stuctures
    //
    // ***************************************************************************
     
    type
      _BLUETOOTH_DEVICE_INFO = record
        dwSize: DWORD;                 //  size, in bytes, of this structure - must be the sizeof(BLUETOOTH_DEVICE_INFO)
        Address: BLUETOOTH_ADDRESS;    //  Bluetooth address
        ulClassofDevice: ULONG;        //  Bluetooth "Class of Device"
        fConnected: BOOL;              //  Device connected/in use
        fRemembered: BOOL;             //  Device remembered
        fAuthenticated: BOOL;          //  Device authenticated/paired/bonded
        stLastSeen: SYSTEMTIME;        //  Last time the device was seen
        stLastUsed: SYSTEMTIME;        //  Last time the device was used for other than RNR, inquiry, or SDP
        szName: array [0..BLUETOOTH_MAX_NAME_SIZE - 1] of WideChar;  //  Name of the device
      end;
      {$EXTERNALSYM _BLUETOOTH_DEVICE_INFO}
      BLUETOOTH_DEVICE_INFO = _BLUETOOTH_DEVICE_INFO;
      {$EXTERNALSYM BLUETOOTH_DEVICE_INFO}
      PBLUETOOTH_DEVICE_INFO = BLUETOOTH_DEVICE_INFO;
      {$EXTERNALSYM PBLUETOOTH_DEVICE_INFO}
      TBlueToothDeviceInfo = BLUETOOTH_DEVICE_INFO;
      PBlueToothDeviceInfo = PBLUETOOTH_DEVICE_INFO;
     
    // ***************************************************************************
    //
    //  Device Enumeration
    //
    //  Description:
    //      Enumerates the Bluetooth devices. The types of returned device depends
    //      on the flags set in the BLUETOOTH_DEVICE_SEARCH_PARAMS (see structure
    //      definition for details).
    //
    //  Sample Usage:
    //      HBLUETOOTH_DEVICE_FIND hFind;
    //      BLUETOOTH_DEVICE_SEARCH_PARAMS btsp = { sizeof(btsp) };
    //      BLUETOOTH_DEVICE_INFO btdi = { sizeof(btdi) };
    //
    //      btsp.fReturnAuthenticated = TRUE;
    //      btsp.fReturnRemembered    = TRUE;
    //
    //      hFind = BluetoothFindFirstDevice( &btsp, &btdi );
    //      if ( NULL != hFind )
    //      {
    //          do
    //          {
    //              //
    //              //  TODO:   Do something useful with the device info.
    //              //
    //
    //          } while( BluetoothFindNextDevice( hFind, &btdi ) );
    //
    //          BluetoothFindDeviceClose( hFind );
    //      }
    //
    // ***************************************************************************
     
    type
      _BLUETOOTH_DEVICE_SEARCH_PARAMS = record
        dwSize: DWORD;                //  IN  sizeof this structure
        fReturnAuthenticated: BOOL;   //  IN  return authenticated devices
        fReturnRemembered: BOOL;      //  IN  return remembered devices
        fReturnUnknown: BOOL;         //  IN  return unknown devices
        fReturnConnected: BOOL;       //  IN  return connected devices
     
        fIssueInquiry: BOOL;          //  IN  issue a new inquiry
        cTimeoutMultiplier: UCHAR;    //  IN  timeout for the inquiry
     
        hRadio: THandle;              //  IN  handle to radio to enumerate -
                                      //      NULL == all radios will be searched
      end;
      {$EXTERNALSYM _BLUETOOTH_DEVICE_SEARCH_PARAMS}
      BLUETOOTH_DEVICE_SEARCH_PARAMS = _BLUETOOTH_DEVICE_SEARCH_PARAMS;
      {$EXTERNALSYM BLUETOOTH_DEVICE_SEARCH_PARAMS}
      TBlueToothDeviceSearchParams = BLUETOOTH_DEVICE_SEARCH_PARAMS;
     
      HBLUETOOTH_DEVICE_FIND = THandle;
      {$EXTERNALSYM HBLUETOOTH_DEVICE_FIND}
     
    //
    //  Description:
    //      Begins the enumeration of Bluetooth devices.
    //
    //  Parameters:
    //      pbtsp
    //          A pointer to a BLUETOOTH_DEVICE_SEARCH_PARAMS structure. This
    //          structure contains the flags and inputs used to conduct the search.
    //          See BLUETOOTH_DEVICE_SEARCH_PARAMS for details.
    //
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure to return information
    //          about the first Bluetooth device found. Note that the dwSize member
    //          of the structure must be the sizeof(BLUETOOTH_DEVICE_INFO) before
    //          calling because the APIs hast to know the size of the buffer being
    //          past in. The dwSize member must also match the exact 
    //          sizeof(BLUETOOTH_DEVICE_INFO) or the call will fail.
    //
    //  Return Values:
    //      NULL
    //          Error opening radios or not devices found. Use GetLastError for more info.
    //
    //          ERROR_INVALID_PARAMETER
    //              pbtsp parameter or pbtdi parameter is NULL.
    //
    //          ERROR_REVISION_MISMATCH
    //              The pbtfrp structure is not the right length.
    //
    //          other Win32 errors
    //
    //      any other value
    //          Success. The return handle is valid and pbtdi points to valid data.
    //
     
    function BluetoothFindFirstDevice(const pbtsp: BLUETOOTH_DEVICE_SEARCH_PARAMS; var pbtdi: BLUETOOTH_DEVICE_INFO): HBLUETOOTH_DEVICE_FIND; stdcall;
    {$EXTERNALSYM BluetoothFindFirstDevice}
     
    //
    //  Description:
    //      Finds the next Bluetooth device in the enumeration.
    //
    //  Parameters:
    //      hFind
    //          The handle returned from BluetoothFindFirstDevice().
    //
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure to return information
    //          about the first Bluetooth device found. Note that the dwSize member
    //          of the structure must be the sizeof(BLUETOOTH_DEVICE_INFO) before
    //          calling because the APIs hast to know the size of the buffer being
    //          past in. The dwSize member must also match the exact
    //          sizeof(BLUETOOTH_DEVICE_INFO) or the call will fail.
    //
    //  Return Values:
    //      TRUE
    //          Next device succesfully found. pHandleOut points to valid handle.
    //
    //      FALSE
    //          No device found. pHandleOut points to an invalid handle. Call
    //          GetLastError() for more details.
    //
    //          ERROR_INVALID_HANDLE
    //              The handle is NULL.
    //
    //          ERROR_NO_MORE_ITEMS
    //              No more radios found.
    //
    //          ERROR_OUTOFMEMORY
    //              Out of memory.
    //
    //          other Win32 errors
    //
     
    function BluetoothFindNextDevice(hFind: HBLUETOOTH_DEVICE_FIND; var pbtdi: BLUETOOTH_DEVICE_INFO): BOOL; stdcall;
    {$EXTERNALSYM BluetoothFindNextDevice}
     
    //
    //  Description:
    //      Closes the enumeration handle.
    //
    //  Parameters:
    //      hFind
    //          The handle returned from BluetoothFindFirstDevice().
    //
    //  Return Values:
    //      TRUE
    //          Handle succesfully closed.
    //
    //      FALSE
    //          Failure. Check GetLastError() for details.
    //
    //          ERROR_INVALID_HANDLE
    //              The handle is NULL.
    //
     
    function BluetoothFindDeviceClose(hFind: HBLUETOOTH_DEVICE_FIND): BOOL; stdcall;
    {$EXTERNALSYM BluetoothFindDeviceClose}
     
    //
    //  Description:
    //      Retrieves information about a remote device.
    //
    //      Fill in the dwSize and the Address members of the pbtdi structure
    //      being passed in. On success, the rest of the members will be filled
    //      out with the information that the system knows.
    //
    //  Parameters:
    //      hRadio
    //          Handle to a local radio retrieved through BluetoothFindFirstRadio()
    //          et al or SetupDiEnumerateDeviceInterfaces()
    //
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure to return information
    //          about the first Bluetooth device found. The dwSize member of the
    //          structure must be the sizeof the structure in bytes. The Address
    //          member must be filled out with the Bluetooth address of the remote
    //          device.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          Success. Information returned.
    //
    //      ERROR_REVISION_MISMATCH
    //          The size of the BLUETOOTH_DEVICE_INFO isn't compatible. Check
    //          the dwSize member of the BLUETOOTH_DEVICE_INFO structure you
    //          passed in.
    //
    //      ERROR_NOT_FOUND
    //          The radio is not known by the system or the Address field of
    //          the BLUETOOTH_DEVICE_INFO structure is all zeros.
    //
    //      ERROR_INVALID_PARAMETER
    //          pbtdi is NULL.
    //
    //      other error codes
    //
     
    function BluetoothGetDeviceInfo(hRadio: THandle; var pbtdi: BLUETOOTH_DEVICE_INFO): DWORD; stdcall;
    {$EXTERNALSYM BluetoothGetDeviceInfo}
     
    //
    //  Description:
    //      Updates the computer local cache about the device.
    //
    //  Parameters:
    //      pbtdi
    //          A pointer to the BLUETOOTH_DEVICE_INFO structure to be updated.
    //          The following members must be valid:
    //              dwSize
    //                  Must match the size of the structure.
    //              Address
    //                  Must be a previously found radio address.
    //              szName
    //                  New name to be stored.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The device information was updated successfully.
    //
    //      ERROR_INVALID_PARAMETER
    //          pbtdi is NULL.
    //
    //      ERROR_REVISION_MISMATCH
    //          pbtdi->dwSize is invalid.
    //
    //      other Win32 error codes.
    //
     
    function BluetoothUpdateDeviceRecord(var pbtdi: BLUETOOTH_DEVICE_INFO): DWORD; stdcall;
    {$EXTERNALSYM BluetoothUpdateDeviceRecord}
     
    //
    //  Description:
    //      Delete the authentication (aka "bond") between the computer and the
    //      device. Also purges any cached information about the device.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The device was removed successfully.
    //
    //      ERROR_NOT_FOUND
    //          The device was not found. If no Bluetooth radio is installed,
    //          the devices could not be enumerated or removed.
    //
     
    function BluetoothRemoveDevice(var pAddress: BLUETOOTH_ADDRESS): DWORD; stdcall;
    {$EXTERNALSYM BluetoothRemoveDevice}
     
    // ***************************************************************************
    //
    //  Device Picker Dialog
    //
    //  Description:
    //      Invokes a common dialog for selecting Bluetooth devices. The list
    //      of devices displayed to the user is determined by the flags and
    //      settings the caller specifies in the BLUETOOTH_SELECT_DEVICE_PARAMS
    //      (see structure definition for more details).
    //
    //      If BluetoothSelectDevices() returns TRUE, the caller must call
    //      BluetoothSelectDevicesFree() or memory will be leaked within the
    //      process.
    //
    //  Sample Usage:
    //
    //      BLUETOOTH_SELECT_DEVICE_PARAMS btsdp = { sizeof(btsdp) };
    //
    //      btsdp.hwndParent = hDlg;
    //      btsdp.fShowUnknown = TRUE;
    //      btsdp.fAddNewDeviceWizard = TRUE;
    //
    //      BOOL b = BluetoothSelectDevices( &btsdp );
    //      if ( b )
    //      {
    //          BLUETOOTH_DEVICE_INFO * pbtdi = btsdp.pDevices;
    //          for ( ULONG cDevice = 0; cDevice < btsdp.cNumDevices; cDevice ++ )
    //          {
    //              if ( pbtdi->fAuthenticated || pbtdi->fRemembered )
    //              {
    //                  //
    //                  //  TODO:   Do something usefull with the device info
    //                  //
    //              }
    //
    //              pbtdi = (BLUETOOTH_DEVICE_INFO *) ((LPBYTE)pbtdi + pbtdi->dwSize);
    //          }
    //
    //          BluetoothSelectDevicesFree( &btsdp );
    //      }
    //
    // ***************************************************************************
     
    type
      _BLUETOOTH_COD_PAIRS = record
        ulCODMask: ULONG;                   //  ClassOfDevice mask to compare
        pcszDescription: LPWSTR;            //  Descriptive string of mask
      end;
      {$EXTERNALSYM _BLUETOOTH_COD_PAIRS}
      BLUETOOTH_COD_PAIRS = _BLUETOOTH_COD_PAIRS;
      {$EXTERNALSYM BLUETOOTH_COD_PAIRS}
      TBlueToothCodPairs = BLUETOOTH_COD_PAIRS;
      PBlueToothCodPairs = ^BLUETOOTH_COD_PAIRS;
     
      PFN_DEVICE_CALLBACK = function(pvParam: Pointer; pDevice: PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;
      {$EXTERNALSYM PFN_DEVICE_CALLBACK}
     
      _BLUETOOTH_SELECT_DEVICE_PARAMS = record
        dwSize: DWORD;                          //  IN  sizeof this structure
     
        cNumOfClasses: ULONG;                   //  IN  Number in prgClassOfDevice - if ZERO search for all devices
        prgClassOfDevices: PBlueToothCodPairs;  //  IN  Array of CODs to find.
     
        pszInfo: LPWSTR;                        //  IN  If not NULL, sets the "information" text
     
        hwndParent: HWND;                       //  IN  parent window - NULL == no parent
     
        fForceAuthentication: BOOL;             //  IN  If TRUE, authenication will be forced before returning
        fShowAuthenticated: BOOL;               //  IN  If TRUE, authenticated devices will be shown in the picker
        fShowRemembered: BOOL;                  //  IN  If TRUE, remembered devices will be shown in the picker
        fShowUnknown: BOOL;                     //  IN  If TRUE, unknown devices that are not authenticated or "remember" will be shown.
     
        fAddNewDeviceWizard: BOOL;              //  IN  If TRUE, invokes the add new device wizard.
        fSkipServicesPage: BOOL;                //  IN  If TRUE, skips the "Services" page in the wizard.
     
        pfnDeviceCallback: PFN_DEVICE_CALLBACK; //  IN  If non-NULL, a callback that will be called for each device. If the
                                                //      the callback returns TRUE, the item will be added. If the callback is
                                                //      is FALSE, the item will not be shown.
        pvParam: Pointer;                       //  IN  Parameter to be passed to pfnDeviceCallback as the pvParam.
     
        cNumDevices: DWORD;                     //  IN  number calles wants - ZERO == no limit.
                                                //  OUT the number of devices returned.
     
        pDevices: PBLUETOOTH_DEVICE_INFO;       //  OUT pointer to an array for BLUETOOTH_DEVICE_INFOs.
                                                //      call BluetoothSelectDevicesFree() to free
      end;
      {$EXTERNALSYM _BLUETOOTH_SELECT_DEVICE_PARAMS}
      BLUETOOTH_SELECT_DEVICE_PARAMS = _BLUETOOTH_SELECT_DEVICE_PARAMS;
      {$EXTERNALSYM BLUETOOTH_SELECT_DEVICE_PARAMS}
      TBlueToothSelectDeviceParams = BLUETOOTH_SELECT_DEVICE_PARAMS;
      PBlueToothSelectDeviceParams = ^BLUETOOTH_SELECT_DEVICE_PARAMS;
     
    //
    //  Description:
    //      (See header above)
    //
    //  Return Values:
    //      TRUE
    //          User selected a device. pbtsdp->pDevices points to valid data.
    //          Caller should check the fAuthenticated && fRemembered flags to
    //          determine which devices we successfuly authenticated or valid
    //          selections by the user.
    //
    //          Use BluetoothSelectDevicesFree() to free the nessecary data
    //          such as pDevices only if this function returns TRUE.
    //
    //      FALSE
    //          No valid data returned. Call GetLastError() for possible details
    //          of the failure. If GLE() is:
    //
    //          ERROR_CANCELLED
    //              The user cancelled  the request.
    //
    //          ERROR_INVALID_PARAMETER
    //              The pbtsdp is NULL.
    //
    //          ERROR_REVISION_MISMATCH
    //              The structure passed in as pbtsdp is of an unknown size.
    //
    //          other WIN32 errors
    //
     
    function BluetoothSelectDevices(pbtsdp: PBlueToothSelectDeviceParams): BOOL; stdcall;
    {$EXTERNALSYM BluetoothSelectDevices}
     
    //
    //  Description:
    //      This function should only be called if BluetoothSelectDevices() returns
    //      TRUE. This function will free any memory and resource returned by the
    //      BluetoothSelectDevices() in the BLUETOOTH_SELECT_DEVICE_PARAMS
    //      structure.
    //
    //  Return Values:
    //      TRUE
    //          Success.
    //
    //      FALSE
    //          Nothing to free.
    //
     
    function BluetoothSelectDevicesFree(pbtsdp: PBlueToothSelectDeviceParams): BOOL; stdcall;
    {$EXTERNALSYM BluetoothSelectDevicesFree}
     
    // ***************************************************************************
    //
    //  Device Property Sheet
    //
    // ***************************************************************************
     
    //
    //  Description:
    //      Invokes the CPLs device info property sheet.
    //
    //  Parameters:
    //      hwndParent
    //          HWND to parent the property sheet.
    //
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure of the device
    //          to be displayed.
    //
    //  Return Values:
    //      TRUE
    //          The property page was successfully displayed.
    //
    //      FALSE
    //          Failure. The property page was not displayed. Check GetLastError
    //          for more details.
    //
     
    function BluetoothDisplayDeviceProperties(hwndParent: HWND; pbtdi: PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;
    {$EXTERNALSYM BluetoothDisplayDeviceProperties}
     
    // ***************************************************************************
    //
    //  Radio Authentication
    //
    // ***************************************************************************
     
    //
    //  Description:
    //      Sends an authentication request to a remote device. 
    //                                           
    //      There are two modes of operation. "Wizard mode" and "Blind mode."
    //
    //      "Wizard mode" is invoked when the pszPasskey is NULL. This will cause
    //      the "Bluetooth Connection Wizard" to be invoked. The user will be
    //      prompted to enter a passkey during the wizard after which the
    //      authentication request will be sent. The user will see the success
    //      or failure of the authentication attempt. The user will also be
    //      given the oppurtunity to try to fix a failed authentication.
    //
    //      "Blind mode" is invoked when the pszPasskey is non-NULL. This will
    //      cause the computer to send a authentication request to the remote
    //      device. No UI is ever displayed. The Bluetooth status code will be
    //      mapped to a Win32 Error code.
    //
    //  Parameters:
    //
    //      hwndParent
    //          The window to parent the authentication wizard. If NULL, the 
    //          wizard will be parented off the desktop.
    //
    //      hRadio
    //          A valid local radio handle or NULL. If NULL, then all radios will
    //          be tired. If any of the radios succeed, then the call will
    //          succeed.
    //
    //      pbtdi
    //          BLUETOOTH_DEVICE_INFO record of the device to be authenticated.
    //
    //      pszPasskey
    //          PIN to be used to authenticate the device.  If NULL, then UI is
    //          displayed and the user steps through the authentication process.
    //          If not NULL, no UI is shown.  The passkey is NOT NULL terminated.
    //
    //      ulPasskeyLength
    //          Length of szPassKey in bytes. The length must be less than or 
    //          equal to BLUETOOTH_MAX_PASSKEY_SIZE * sizeof(WCHAR).
    //
    //  Return Values:
    //
    //      ERROR_SUCCESS
    //          Success.
    //
    //      ERROR_CANCELLED
    //          User aborted the operation.
    //
    //      ERROR_INVALID_PARAMETER
    //          The device structure in pbtdi is invalid.
    //
    //      ERROR_NO_MORE_ITEMS
    //          The device in pbtdi is already been marked as authenticated.
    //
    //      other WIN32 error
    //          Failure. Return value is the error code.
    //
    //      For "Blind mode," here is the current mapping of Bluetooth status
    //      code to Win32 error codes:
    //
    //          { BTH_ERROR_SUCCESS,                ERROR_SUCCESS },
    //          { BTH_ERROR_NO_CONNECTION,          ERROR_DEVICE_NOT_CONNECTED },
    //          { BTH_ERROR_PAGE_TIMEOUT,           WAIT_TIMEOUT },
    //          { BTH_ERROR_HARDWARE_FAILURE,       ERROR_GEN_FAILURE },
    //          { BTH_ERROR_AUTHENTICATION_FAILURE, ERROR_NOT_AUTHENTICATED },
    //          { BTH_ERROR_MEMORY_FULL,            ERROR_NOT_ENOUGH_MEMORY },
    //          { BTH_ERROR_CONNECTION_TIMEOUT,     WAIT_TIMEOUT },
    //          { BTH_ERROR_LMP_RESPONSE_TIMEOUT,   WAIT_TIMEOUT },
    //          { BTH_ERROR_MAX_NUMBER_OF_CONNECTIONS, ERROR_REQ_NOT_ACCEP },
    //          { BTH_ERROR_PAIRING_NOT_ALLOWED,    ERROR_ACCESS_DENIED },
    //          { BTH_ERROR_UNSPECIFIED_ERROR,      ERROR_NOT_READY },
    //          { BTH_ERROR_LOCAL_HOST_TERMINATED_CONNECTION, ERROR_VC_DISCONNECTED },
    //
     
    function BluetoothAuthenticateDevice(
        hwndParent: HWND;
        hRadio: THandle;
        pbtbi: PBLUETOOTH_DEVICE_INFO;
        pszPasskey: PWideChar;
        ulPasskeyLength: ULONG): DWORD; stdcall;
    {$EXTERNALSYM BluetoothAuthenticateDevice}
     
    //
    //  Description:
    //      Allows the caller to prompt for multiple devices to be authenticated
    //      within a single instance of the "Bluetooth Connection Wizard."
    //
    //  Parameters:
    //
    //      hwndParent
    //          The window to parent the authentication wizard. If NULL, the 
    //          wizard will be parented off the desktop.
    //
    //      hRadio
    //          A valid local radio handle or NULL. If NULL, then all radios will
    //          be tired. If any of the radios succeed, then the call will
    //          succeed.
    //
    //      cDevices
    //          Number of devices in the rgbtdi array.
    //
    //      rgbtdi
    //          An array BLUETOOTH_DEVICE_INFO records of the devices to be
    //          authenticated.
    //
    //  Return Values:
    //
    //      ERROR_SUCCESS
    //          Success. Check the fAuthenticate flag on each of the devices.
    //
    //      ERROR_CANCELLED
    //          User aborted the operation. Check the fAuthenticate flags on 
    //          each device to determine if any of the devices were authenticated
    //          before the user cancelled the operation.
    //
    //      ERROR_INVALID_PARAMETER
    //          One of the items in the array of devices is invalid.
    //
    //      ERROR_NO_MORE_ITEMS
    //          All the devices in the array of devices are already been marked as
    //          being authenticated.
    //
    //      other WIN32 error
    //          Failure. Return value is the error code.
    //
     
    function BluetoothAuthenticateMultipleDevices(
        hwndParent: HWND;
        hRadio: THandle;
        cDevices: DWORD;
        pbtdi: PBLUETOOTH_DEVICE_INFO): DWORD; stdcall;
    {$EXTERNALSYM BluetoothAuthenticateMultipleDevices}
     
    // ***************************************************************************
    //
    //  Bluetooth Services
    //
    // ***************************************************************************
     
    const
      BLUETOOTH_SERVICE_DISABLE  = $00;
      {$EXTERNALSYM BLUETOOTH_SERVICE_DISABLE}
      BLUETOOTH_SERVICE_ENABLE   = $01;
      {$EXTERNALSYM BLUETOOTH_SERVICE_ENABLE}
      BLUETOOTH_SERVICE_MASK     = BLUETOOTH_SERVICE_ENABLE or BLUETOOTH_SERVICE_DISABLE;
      {$EXTERNALSYM BLUETOOTH_SERVICE_MASK}
     
    //
    //  Description:
    //      Enables/disables the services for a particular device.
    //
    //      The system maintains a mapping of service guids to supported drivers for
    //      Bluetooth-enabled devices. Enabling a service installs the corresponding
    //      device driver. Disabling a service removes the corresponding device driver.
    //
    //      If a non-supported service is enabled, a driver will not be installed.
    //
    //  Parameters
    //      hRadio
    //          Handle of the local Bluetooth radio device.
    //
    //      pbtdi
    //          Pointer to a BLUETOOTH_DEVICE_INFO record.
    //
    //      pGuidService
    //          The service GUID on the remote device.
    //
    //      dwServiceFlags
    //          Flags to adjust the service.
    //              BLUETOOTH_SERVICE_DISABLE   -   disable the service
    //              BLUETOOTH_SERVICE_ENABLE    -   enables the service
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The call was successful.
    //
    //      ERROR_INVALID_PARAMETER
    //          dwServiceFlags are invalid.
    //
    //      ERROR_SERVICE_DOES_NOT_EXIST
    //          The GUID in pGuidService is not supported.
    //
    //      other WIN32 error
    //          The call failed.
    //
     
    function BluetoothSetServiceState(
        hRadio: THandle;
        pbtdi: PBLUETOOTH_DEVICE_INFO;
        const pGuidService: TGUID;
        dwServiceFlags: DWORD): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSetServiceState}
     
    //
    //  Description:
    //      Enumerates the services guids enabled on a particular device. If hRadio
    //      is NULL, all device will be searched for the device and all the services 
    //      enabled will be returned.
    //
    //  Parameters:
    //      hRadio
    //          Handle of the local Bluetooth radio device. If NULL, it will search
    //          all the radios for the address in the pbtdi.
    //
    //      pbtdi
    //          Pointer to a BLUETOOTH_DEVICE_INFO record.
    //
    //      pcService
    //          On input, the number of records pointed to by pGuidServices.
    //          On output, the number of valid records return in pGuidServices.
    //
    //      pGuidServices
    //          Pointer to memory that is at least *pcService in length.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The call succeeded. pGuidServices is valid.
    //
    //      ERROR_MORE_DATA
    //          The call succeeded. pGuidService contains an incomplete list of
    //          enabled service GUIDs.
    //
    //      other WIN32 errors
    //          The call failed.
    //
     
    function BluetoothEnumerateInstalledServices(
        hRadio: THandle;
        pbtdi: PBLUETOOTH_DEVICE_INFO;
        var pcServices: DWORD;
        pGuidServices: PGUID): DWORD; stdcall;
    {$EXTERNALSYM BluetoothEnumerateInstalledServices}
     
    //
    //  Description:
    //      Change the discovery state of the local radio(s).
    //      If hRadio is NULL, all the radios will be set.
    //
    //      Use BluetoothIsDiscoverable() to determine the radios current state.
    //
    //      The system ensures that a discoverable system is connectable, thus
    //      the radio must allow incoming connections (see 
    //      BluetoothEnableIncomingConnections) prior to making a radio 
    //      discoverable. Failure to do so will result in this call failing
    //      (returns FALSE).
    //
    //  Parameters:
    //      hRadio
    //          If not NULL, changes the state of a specific radio.
    //          If NULL, the API will interate through all the radios.
    //
    //      fEnabled
    //          If FALSE, discovery will be disabled.
    //
    //  Return Values
    //      TRUE
    //          State was successfully changed. If the caller specified NULL for
    //          hRadio, at least of the radios accepted the state change.
    //
    //      FALSE
    //          State was not changed. If the caller specified NULL for hRadio, all
    //          of the radios did not accept the state change.
    //
     
    function BluetoothEnableDiscovery(hRadio: THandle; fEnabled: BOOL): BOOL; stdcall;
    {$EXTERNALSYM BluetoothEnableDiscovery}
     
    //
    //  Description:
    //      Determines if the Bluetooth radios are discoverable. If there are 
    //      multiple radios, the first one to say it is discoverable will cause 
    //      this function to return TRUE.
    //
    //  Parameters:
    //      hRadio
    //          Handle of the radio to check. If NULL, it will check all local
    //          radios.
    //
    //  Return Values:
    //      TRUE
    //          A least one radio is discoverable.
    //
    //      FALSE
    //          No radios are discoverable.
    //
     
    function BluetoothIsDiscoverable(hRadio: THandle): BOOL; stdcall;
    {$EXTERNALSYM BluetoothIsDiscoverable}
     
    //
    //  Description:
    //      Enables/disables the state of a radio to accept incoming connections.
    //      If hRadio is NULL, all the radios will be set.
    //
    //      Use BluetoothIsConnectable() to determine the radios current state.
    //
    //      The system enforces that a radio that is not connectable is not
    //      discoverable too. The radio must be made non-discoverable (see 
    //      BluetoothEnableDiscovery) prior to making a radio non-connectionable. 
    //      Failure to do so will result in this call failing (returns FALSE).
    //
    //  Parameters:
    //      hRadio
    //          If not NULL, changes the state of a specific radio.
    //          If NULL, the API will interate through all the radios.
    //
    //      fEnabled
    //          If FALSE, incoming connection will be disabled.
    //
    //  Return Values
    //      TRUE
    //          State was successfully changed. If the caller specified NULL for
    //          hRadio, at least of the radios accepted the state change.
    //
    //      FALSE
    //          State was not changed. If the caller specified NULL for hRadio, all
    //          of the radios did not accept the state change.
    //
     
    function BluetoothEnableIncomingConnections(hRadio: THandle; fEnabled: BOOL): BOOL; stdcall;
    {$EXTERNALSYM BluetoothEnableIncomingConnections}
     
    //
    //  Description:
    //      Determines if the Bluetooth radios are connectable. If there are 
    //      multiple radios, the first one to say it is connectable will cause 
    //      this function to return TRUE.
    //
    //  Parameters:
    //      hRadio
    //          Handle of the radio to check. If NULL, it will check all local
    //          radios.
    //
    //  Return Values:
    //      TRUE
    //          A least one radio is allowing incoming connections.
    //
    //      FALSE
    //          No radios are allowing incoming connections.
    //
     
    function BluetoothIsConnectable(hRadio: THandle): BOOL; stdcall;
    {$EXTERNALSYM BluetoothIsConnectable}
     
    // ***************************************************************************
    //
    //  Authentication Registration
    //
    // ***************************************************************************
     
    type
      HBLUETOOTH_AUTHENTICATION_REGISTRATION = THandle;
      {$EXTERNALSYM HBLUETOOTH_AUTHENTICATION_REGISTRATION}
     
      PFN_AUTHENTICATION_CALLBACK = function(pvParam: Pointer; pDevice: PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;
      {$EXTERNALSYM PFN_AUTHENTICATION_CALLBACK}
     
    //
    //  Description:
    //      Registers a callback function to be called when a particular device
    //      requests authentication. The request is sent to the last application
    //      that requested authentication for a particular device.
    //
    //  Parameters:
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure. The Bluetooth
    //          address will be used for comparision.
    //
    //      phRegHandle
    //          A pointer to where the registration HANDLE value will be 
    //          stored. Call BluetoothUnregisterAuthentication() to close
    //          the handle.
    //
    //      pfnCallback
    //          The function that will be called when the authentication event
    //          occurs. This function should match PFN_AUTHENTICATION_CALLBACK's
    //          prototype.
    //
    //      pvParam
    //          Optional parameter to be past through to the callback function.
    //          This can be anything the application was to define.
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          Success. A valid registration handle was returned.
    //
    //      ERROR_OUTOFMEMORY
    //          Out of memory.
    //
    //      other Win32 error.
    //          Failure. The registration handle is invalid.
    //
     
    function BluetoothRegisterForAuthentication(
        pbtdi: PBLUETOOTH_DEVICE_INFO;
        var phRegHandle: HBLUETOOTH_AUTHENTICATION_REGISTRATION;
        pfnCallback: PFN_AUTHENTICATION_CALLBACK;
        pvParam: Pointer): DWORD; stdcall;
    {$EXTERNALSYM BluetoothRegisterForAuthentication}
     
    //
    //  Description:
    //      Unregisters an authentication callback and closes the handle. See 
    //      BluetoothRegisterForAuthentication() for more information about
    //      authentication registration.
    //
    //  Parameters:
    //      hRegHandle
    //          Handle returned by BluetoothRegisterForAuthentication().
    //
    //  Return Value:
    //      TRUE
    //          The handle was successfully closed.
    //
    //      FALSE
    //          The handle was not successfully closed. Check GetLastError for
    //          more details.
    //
    //          ERROR_INVALID_HANDLE
    //              The handle is NULL.
    //
    //          other Win32 errors.
    //
     
    function BluetoothUnregisterAuthentication(hRegHandle: HBLUETOOTH_AUTHENTICATION_REGISTRATION): BOOL; stdcall;
    {$EXTERNALSYM BluetoothUnregisterAuthentication}
     
    //
    //  Description:
    //      This function should be called after receiving an authentication request
    //      to send the passkey response.
    //
    //  Parameters:
    //
    //      hRadio
    //          Optional handle to the local radio. If NULL, the function will try
    //          each radio until one succeeds.
    //
    //      pbtdi
    //          A pointer to a BLUETOOTH_DEVICE_INFO structure describing the device
    //          being authenticated. This can be the same structure passed to the 
    //          callback function.
    //
    //      pszPasskey
    //          A pointer to UNICODE zero-terminated string of the passkey response
    //          that should be sent back to the authenticating device.
    //
    //  Return Values:
    //      ERROR_SUCESS
    //          The device accepted the passkey response. The device is authenticated.
    //
    //      ERROR_CANCELED
    //          The device denied the passkey reponse. This also will returned if there
    //          is a communications problem with the local radio.
    //
    //      E_FAIL
    //          The device returned a failure code during authentication.
    //
    //      other Win32 error codes
    //
     
    function BluetoothSendAuthenticationResponse(
        hRadio: THandle;
        pbtdi: PBLUETOOTH_DEVICE_INFO;
        pszPasskey: LPWSTR): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSendAuthenticationResponse}
     
    // ***************************************************************************
    //
    //  SDP Parsing Functions
    //
    // ***************************************************************************
     
    type
      TSpdElementDataString = record
        // raw string buffer, may not be encoded as ANSI, use
        // BluetoothSdpGetString to convert the value if it is described
        // by the base language attribute ID list
        value: PBYTE;
        // raw length of the string, may not be NULL terminuated
        length: ULONG;
      end;
     
      TSpdElementDataUrl = record
        value: PBYTE;
        length: ULONG;
      end;
     
      // type == SDP_TYPE_SEQUENCE
      TSpdElementDataSequence = record
        // raw sequence, starts at sequence element header
        value: PBYTE;
        // raw sequence length
        length: ULONG;
      end;
     
      // type == SDP_TYPE_ALTERNATIVE
      TSpdElementDataAlternative = record
        // raw alternative, starts at alternative element header
        value: PBYTE;
        // raw alternative length
        length: ULONG;
      end;
     
      _SDP_ELEMENT_DATA = record
        //
        // Enumeration of SDP element types.  Generic element types will have a
        // specificType value other then SDP_ST_NONE.  The generic types are:
        // o SDP_TYPE_UINT
        // o SDP_TYPE_INT
        // o SDP_TYPE_UUID
        //
        type_: SDP_TYPE;
     
        //
        // Specific types for the generic SDP element types.
        //
        specificType: SDP_SPECIFICTYPE;
     
        //
        // Union of all possible data types.  type and specificType will indicate
        // which field is valid.  For types which do not have a valid specificType,
        // specific type will be SDP_ST_NONE.
        //
        case Integer of
            // type == SDP_TYPE_INT
            0: (int128: SDP_LARGE_INTEGER_16);        // specificType == SDP_ST_INT128
            1: (int64: LONGLONG);                     // specificType == SDP_ST_INT64
            2: (int32: Integer);                         // specificType == SDP_ST_INT32
            3: (int16: SHORT);                        // specificType == SDP_ST_INT16
            4: (int8: CHAR);                          // specificType == SDP_ST_INT8
     
            // type == SDP_TYPE_UINT
            5: (uint128: SDP_ULARGE_INTEGER_16);      // specificType == SDP_ST_UINT128
            6: (uint64: Int64);                   // specificType == SDP_ST_UINT64
            7: (uint32: ULONG);                       // specificType == SDP_ST_UINT32
            8: (uint16: Word);                      // specificType == SDP_ST_UINT16
            9: (uint8: UCHAR);                        // specificType == SDP_ST_UINT8
     
            // type == SDP_TYPE_BOOLEAN
            10: (booleanVal: UCHAR);
     
            // type == SDP_TYPE_UUID
            11: (uuid128: TGUID);                       // specificType == SDP_ST_UUID128
            12: (uuid32: ULONG);                       // specificType == SDP_ST_UUID32
            13: (uuid16: Word);                      // specificType == SDP_ST_UUID32
     
            // type == SDP_TYPE_STRING
            14: (string_: TSpdElementDataString);
            // type == SDP_TYPE_URL
            15: (url: TSpdElementDataUrl);
     
            // type == SDP_TYPE_SEQUENCE
            16: (sequence: TSpdElementDataSequence);
     
            // type == SDP_TYPE_ALTERNATIVE
            17: (alternative: TSpdElementDataAlternative);
      end;
      {$EXTERNALSYM _SDP_ELEMENT_DATA}
      SDP_ELEMENT_DATA = _SDP_ELEMENT_DATA;
      {$EXTERNALSYM SDP_ELEMENT_DATA}
      PSDP_ELEMENT_DATA = ^SDP_ELEMENT_DATA;
      {$EXTERNALSYM PSDP_ELEMENT_DATA}
      TSdpElementData = SDP_ELEMENT_DATA;
      PSdpElementData = PSDP_ELEMENT_DATA;  
     
    //
    // Description:
    //      Retrieves and parses the element found at pSdpStream
    //
    // Parameters:
    //      IN pSdpStream
    //          pointer to valid SDP stream
    //
    //      IN cbSdpStreamLength
    //          length of pSdpStream in bytes
    //
    //      OUT pData
    //          pointer to be filled in with the data of the SDP element at the
    //          beginning of pSdpStream
    //
    // Return Values:
    //      ERROR_INVALID_PARAMETER
    //          one of required parameters is NULL or the pSdpStream is invalid
    //
    //      ERROR_SUCCESS
    //          the sdp element was parsed correctly
    //
     
    function BluetoothSdpGetElementData(
        pSdpStream: PBYTE;
        cbSdpStreamLength: ULONG;
        pData: PSDP_ELEMENT_DATA): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSdpGetElementData}
     
    type
      HBLUETOOTH_CONTAINER_ELEMENT = THandle;
      {$EXTERNALSYM HBLUETOOTH_CONTAINER_ELEMENT}
     
    //
    // Description:
    //      Iterates over a container stream, returning each elemetn contained with
    //      in the container element at the beginning of pContainerStream
    //
    // Parameters:
    //      IN pContainerStream
    //          pointer to valid SDP stream whose first element is either a sequence
    //          or alternative
    //
    //      IN cbContainerlength
    //          length in bytes of pContainerStream
    //
    //      IN OUT pElement
    //          Value used to keep track of location within the stream.  The first
    //          time this function is called for a particular container, *pElement
    //          should equal NULL.  Upon subsequent calls, the value should be
    //          unmodified.
    //
    //      OUT pData
    //          pointer to be filled in with the data of the SDP element at the
    //          current element of pContainerStream
    //
    //  Return Values:
    //      ERROR_SUCCESS
    //          The call succeeded, pData contains the data
    //
    //      ERROR_NO_MORE_ITEMS
    //          There are no more items in the list, the caller should cease calling
    //          BluetoothSdpGetContainerElementData for this container.
    //
    //      ERROR_INVALID_PARAMETER
    //          A required pointer is NULL or the container is not a valid SDP
    //          stream
    //
    // Usage example:
    //
    // HBLUETOOTH_CONTAINER_ELEMENT element;
    // SDP_ELEMENT_DATA data;
    // ULONG result;
    //
    // element = NULL;
    //
    // while (TRUE) {
    //      result = BluetoothSdpGetContainerElementData(
    //          pContainer, ulContainerLength, &element, &data);
    //
    //      if (result == ERROR_NO_MORE_ITEMS) {
    //          // We are done
    //          break;
    //      }
    //      else if (result != ERROR_SUCCESS) {
    //          // error
    //      }
    //
    //      // do something with data ...
    // }
    //
    //
     
    function BluetoothSdpGetContainerElementData(
        pContainerStream: PBYTE;
        cbContainerLength: ULONG;
        var pElement: HBLUETOOTH_CONTAINER_ELEMENT;
        pData: PSDP_ELEMENT_DATA): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSdpGetContainerElementData}
     
    //
    // Description:
    //      Retrieves the attribute value for the given attribute ID.  pRecordStream
    //      must be an SDP stream that is formatted as an SDP record, a SEQUENCE
    //      containing UINT16 + element pairs.
    //
    // Parameters:
    //      IN pRecordStream
    //          pointer to a valid SDP stream which is formatted as a singl SDP
    //          record
    //
    //      IN cbRecordlnegh
    //          length of pRecordStream in bytes
    //
    //      IN usAttributeId
    //          the attribute ID to search for.  see bthdef.h for SDP_ATTRIB_Xxx
    //          values.
    //
    //      OUT pAttributeData
    //          pointer that will contain the attribute ID's value
    //
    // Return Values:
    //      ERRROR_SUCCESS
    //          Call succeeded, pAttributeData contains the attribute value
    //
    //      ERROR_INVALID_PARAMETER
    //          One of the required pointers was NULL, pRecordStream was not a valid
    //          SDP stream, or pRecordStream was not a properly formatted SDP record
    //
    //      ERROR_FILE_NOT_FOUND
    //          usAttributeId was not found in the record
    //
    // Usage:
    //
    // ULONG result;
    // SDP_DATA_ELEMENT data;
    //
    // result = BluetoothSdpGetAttributeValue(
    //      pRecordStream, cbRecordLength, SDP_ATTRIB_RECORD_HANDLE, &data);
    // if (result == ERROR_SUCCESS) {
    //      printf("record handle is 0x%x\n", data.data.uint32);
    // }
    //
     
    function BluetoothSdpGetAttributeValue(
        pRecordStream: PBYTE;
        cbRecordLength: ULONG;
        usAttributeId: Word;
        pAttributeData: PSDP_ELEMENT_DATA): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSdpGetAttributeValue}
     
    //
    // These three fields correspond one to one with the triplets defined in the
    // SDP specification for the language base attribute ID list.
    //
     
    type
      _SDP_STRING_TYPE_DATA = record
        //
        // How the string is encoded according to ISO 639:1988 (E/F): "Code
        // for the representation of names of languages".
        //
        encoding: Word;
     
        //
        // MIBE number from IANA database
        //
        mibeNum: Word;
     
        //
        // The base attribute where the string is to be found in the record
        //
        attributeId: Word;
      end;
      {$EXTERNALSYM _SDP_STRING_TYPE_DATA}
      SDP_STRING_TYPE_DATA = _SDP_STRING_TYPE_DATA;
      {$EXTERNALSYM SDP_STRING_TYPE_DATA}
      PSDP_STRING_TYPE_DATA = ^SDP_STRING_TYPE_DATA;
      {$EXTERNALSYM PSDP_STRING_TYPE_DATA}
      TSdpStringTypeData = SDP_STRING_TYPE_DATA;
      PSdpStringTypeData = PSDP_STRING_TYPE_DATA;  
     
    //
    // Description:
    //      Converts a raw string embedded in the SDP record into a UNICODE string
    //
    // Parameters:
    //      IN pRecordStream
    //          a valid SDP stream which is formatted as an SDP record
    //
    //      IN cbRecordLength
    //          length of pRecordStream in bytes
    //
    //      IN pStringData
    //          if NULL, then the calling thread's locale will be used to search
    //          for a matching string in the SDP record.  If not NUL, the mibeNum
    //          and attributeId will be used to find the string to convert.
    //
    //      IN usStringOffset
    //          the SDP string type offset to convert.  usStringOffset is added to
    //          the base attribute id of the string.   SDP specification defined
    //          offsets are: STRING_NAME_OFFSET, STRING_DESCRIPTION_OFFSET, and
    //          STRING_PROVIDER_NAME_OFFSET (found in bthdef.h).
    //
    //      OUT pszString
    //          if NULL, pcchStringLength will be filled in with the required number
    //          of characters (not bytes) to retrieve the converted string.
    //
    //      IN OUT pcchStringLength
    //          Upon input, if pszString is not NULL, will contain the length of
    //          pszString in characters.  Upon output, it will contain either the
    //          number of required characters including NULL if an error is returned
    //          or the number of characters written to pszString (including NULL).
    //
    //  Return Values:
    //      ERROR_SUCCES
    //          Call was successful and pszString contains the converted string
    //
    //      ERROR_MORE_DATA
    //          pszString was NULL or too small to contain the converted string,
    //          pccxhStringLength contains the required length in characters
    //
    //      ERROR_INVALID_DATA
    //          Could not perform the conversion
    //
    //      ERROR_NO_SYSTEM_RESOURCES
    //          Could not allocate memory internally to perform the conversion
    //
    //      ERROR_INVALID_PARAMETER
    //          One of the rquired pointers was NULL, pRecordStream was not a valid
    //          SDP stream, pRecordStream was not a properly formatted record, or
    //          the desired attribute + offset was not a string.
    //
    //      Other HRESULTs returned by COM
    //
     
    function BluetoothSdpGetString(
        pRecordStream: PBYTE;
        cbRecordLength: ULONG;
        pStringData: PSDP_STRING_TYPE_DATA;
        usStringOffset: Word;
        pszString: PWideChar;
        pcchStringLength: PULONG): DWORD; stdcall;
    {$EXTERNALSYM BluetoothSdpGetString}
     
    // ***************************************************************************
    //
    //  Raw Attribute  Enumeration
    //
    // ***************************************************************************
     
    type
      PFN_BLUETOOTH_ENUM_ATTRIBUTES_CALLBACK = function(
        uAttribId: ULONG;
        pValueStream: PBYTE;
        cbStreamSize: ULONG;
        pvParam: Pointer): BOOL; stdcall;
      {$EXTERNALSYM PFN_BLUETOOTH_ENUM_ATTRIBUTES_CALLBACK}
     
    //
    //  Description:
    //      Enumerates through the SDP record stream calling the Callback function
    //      for each attribute in the record. If the Callback function returns
    //      FALSE, the enumeration is stopped.
    //
    //  Return Values:
    //      TRUE
    //          Success! Something was enumerated.
    //
    //      FALSE
    //          Failure. GetLastError() could be one of the following:
    //
    //          ERROR_INVALID_PARAMETER
    //              pSDPStream or pfnCallback is NULL.
    //
    //          ERROR_INVALID_DATA
    //              The SDP stream is corrupt.
    //
    //          other Win32 errors.
    //
     
    function BluetoothSdpEnumAttributes(
        pSDPStream: PBYTE;
        cbStreamSize: ULONG;
        pfnCallback: PFN_BLUETOOTH_ENUM_ATTRIBUTES_CALLBACK;
        pvParam: Pointer): BOOL; stdcall;
    {$EXTERNALSYM BluetoothSdpEnumAttributes}
     
    // (rom) MACRO
    function BluetoothEnumAttributes(
        pSDPStream: PBYTE;
        cbStreamSize: ULONG;
        pfnCallback: PFN_BLUETOOTH_ENUM_ATTRIBUTES_CALLBACK;
        pvParam: Pointer): BOOL;
    {$EXTERNALSYM BluetoothEnumAttributes}
     
    implementation
     
    const
      btapi = 'irprops.cpl';
     
    // (rom) MACRO implementation
    function BluetoothEnumAttributes(pSDPStream: PBYTE; cbStreamSize: ULONG;
      pfnCallback: PFN_BLUETOOTH_ENUM_ATTRIBUTES_CALLBACK; pvParam: Pointer): BOOL;
    begin
      Result := BluetoothSdpEnumAttributes(pSDPStream, cbStreamSize, pfnCallback, pvParam);
    end;
     
    function BluetoothFindFirstRadio; external btapi name 'BluetoothFindFirstRadio';
    function BluetoothFindNextRadio; external btapi name 'BluetoothFindNextRadio';
    function BluetoothFindRadioClose; external btapi name 'BluetoothFindRadioClose';
    function BluetoothGetRadioInfo; external btapi name 'BluetoothGetRadioInfo';
    function BluetoothFindFirstDevice; external btapi name 'BluetoothFindFirstDevice';
    function BluetoothFindNextDevice; external btapi name 'BluetoothFindNextDevice';
    function BluetoothFindDeviceClose; external btapi name 'BluetoothFindDeviceClose';
    function BluetoothGetDeviceInfo; external btapi name 'BluetoothGetDeviceInfo';
    function BluetoothUpdateDeviceRecord; external btapi name 'BluetoothUpdateDeviceRecord';
    function BluetoothRemoveDevice; external btapi name 'BluetoothRemoveDevice';
    function BluetoothSelectDevices; external btapi name 'BluetoothSelectDevices';
    function BluetoothSelectDevicesFree; external btapi name 'BluetoothSelectDevicesFree';
    function BluetoothDisplayDeviceProperties; external btapi name 'BluetoothDisplayDeviceProperties';
    function BluetoothAuthenticateDevice; external btapi name 'BluetoothAuthenticateDevice';
    function BluetoothAuthenticateMultipleDevices; external btapi name 'BluetoothAuthenticateMultipleDevices';
    function BluetoothSetServiceState; external btapi name 'BluetoothSetServiceState';
    function BluetoothEnumerateInstalledServices; external btapi name 'BluetoothEnumerateInstalledServices';
    function BluetoothEnableDiscovery; external btapi name 'BluetoothEnableDiscovery';
    function BluetoothIsDiscoverable; external btapi name 'BluetoothIsDiscoverable';
    function BluetoothEnableIncomingConnections; external btapi name 'BluetoothEnableIncomingConnections';
    function BluetoothIsConnectable; external btapi name 'BluetoothIsConnectable';
    function BluetoothRegisterForAuthentication; external btapi name 'BluetoothRegisterForAuthentication';
    function BluetoothUnregisterAuthentication; external btapi name 'BluetoothUnregisterAuthentication';
    function BluetoothSendAuthenticationResponse; external btapi name 'BluetoothSendAuthenticationResponse';
    function BluetoothSdpGetElementData; external btapi name 'BluetoothSdpGetElementData';
    function BluetoothSdpGetContainerElementData; external btapi name 'BluetoothSdpGetContainerElementData';
    function BluetoothSdpGetAttributeValue; external btapi name 'BluetoothSdpGetAttributeValue';
    function BluetoothSdpGetString; external btapi name 'BluetoothSdpGetString';
    function BluetoothSdpEnumAttributes; external btapi name 'BluetoothSdpEnumAttributes';
     
    end.
     
     

     
    {
      Copyright (C) 2006 Mike B. Petrichenko
      pmb_stv@mail.ru
      mobileservicesoft@yandex.ru
      ICQ: 190812766
      Phone: +7 (928) 324-58-24
             +7 (928) 819-46-40
     
      All Rights Reserved.
     
      Only for non commercial purpose.
    }
    unit BTDevice;
     
    interface
     
    uses
      BTRadio, BluetoothAPI, Windows;
     
    type
      TBTDeviceSearchFlag = (sfReturnAuthenticated, sfReturnRemembered,
                             sfReturnUnknown, sfReturnConnected);
      TBTDeviceSearchFlags = set of TBTDeviceSearchFlag;
     
      TBTDeviceSelectFlag = (dsForceAuthentication, dsShowAuthenticated,
                             dsShowRemembered, dsShowUnknown, dsAddNewDeviceWizard,
                             dsSkipServicesPage);
      TBTDeviceSelectFlags = set of TBTDeviceSelectFlag;
     
      TBTAuthenticateEvent = procedure (Sender: TObject; var Pwd: string);
     
      TBTDevice = class
      private
        FAddress: BTH_ADDR;
        FAuReg: HBLUETOOTH_AUTHENTICATION_REGISTRATION;
        FBTRadio: TBTRadio;
        FOnAuthenticate: TBTAuthenticateEvent;
     
        function GetAuthenticated: boolean;
        function GetClassOfDevice: cardinal;
        function GetConnected: boolean;
        function GetDeviceInfo: BLUETOOTH_DEVICE_INFO;
        function GetLastSeen: TDateTime;
        function GetLastUsed: TDateTime;
        function GetName: string;
        function GetRemembered: boolean;
     
        procedure SetOnAuthenticate(const Value: TBTAuthenticateEvent);
     
        procedure DoAuthenticate;
     
      protected
        property DeviceInfo: BLUETOOTH_DEVICE_INFO read GetDeviceInfo;
     
      public
        constructor Create(const Addr: BTH_ADDR; const ABTRadio: TBTRadio);
        destructor Destroy; override;
     
        procedure Authenticate(const Pwd: string);
        procedure DisplayProperties;
        procedure Remove;
        procedure Select(const FLags: TBTDeviceSelectFlags);
        procedure Update(const NewName: string);
     
        property Address: BTH_ADDR read FAddress;
        property Authenticated: boolean read GetAuthenticated;
        property BTRadio: TBTRadio read FBTRadio;
        property ClassofDevice: cardinal read GetClassOfDevice;
        property Connected: boolean read GetConnected;
        property LastSeen: TDateTime read GetLastSeen;
        property LastUsed: TDateTime read GetLastUsed;
        property Name: string read GetName;
        property Remembered: boolean read GetRemembered;
     
        property OnAuthenticate: TBTAuthenticateEvent read FOnAuthenticate write SetOnAuthenticate;
      end;
     
    function BTGetDeviceByAddr(const Addr: BTH_ADDR; const ABTRadio: TBTRadio): TBTDevice;
     
    procedure BTEnumDevices(const BTRadio: TBTRadio; const SearchFlags: TBTDeviceSearchFlags; var Devices: TBTAddrArray);
     
    implementation
     
    uses
      BTExceptions, BTStrings, SysUtils;
     
    function BTAuCallBack(pvParam: Pointer; pDevice: PBLUETOOTH_DEVICE_INFO): BOOL; stdcall;
    begin
      TBTDevice(pvParam).DoAuthenticate;
      Result := true;
    end;
     
    function BTGetDeviceByAddr(const Addr: BTH_ADDR; const ABTRadio: TBTRadio): TBTDevice;
    begin
       if (not Assigned(ABTRadio)) then raise BTException.Create(STR_ERROR_INVALID_PARAMETER);
     
       Result := TBTDevice.Create(Addr, ABTRadio);
    end;
     
    procedure BTEnumDevices(const BTRadio: TBTRadio; const SearchFlags: TBTDeviceSearchFlags; var Devices: TBTAddrArray);
    var
      hFind: HBLUETOOTH_DEVICE_FIND;
      SearchParams: BLUETOOTH_DEVICE_SEARCH_PARAMS;
      SearchParamsSize: dword;
      DeviceInfo: BLUETOOTH_DEVICE_INFO;
      DeviceInfoSize: dword;
      Ndx: word;
    begin
      if (not Assigned(BTRadio)) then raise BTException.Create(STR_ERROR_INVALID_PARAMETER);
     
      Ndx := 0;
     
      SearchParamsSize := SizeOf(BLUETOOTH_DEVICE_SEARCH_PARAMS);
      FillChar(SearchParams, SearchParamsSize, 0);
      with SearchParams do begin
        dwSize := SearchParamsSize;
        hRadio := BTRadio.Handle;
        fReturnAuthenticated := (sfReturnAuthenticated in SearchFlags);
        fReturnRemembered := (sfReturnRemembered in SearchFlags);
        fReturnUnknown := (sfReturnUnknown in SearchFlags);
        fReturnConnected := (sfReturnConnected in SearchFlags);
      end;
     
      DeviceInfoSize := SizeOf(BLUETOOTH_DEVICE_INFO);
      FillChar(DeviceInfo, DeviceInfoSize, 0);
      DeviceInfo.dwSize := DeviceInfoSize;
     
      hFind :=  BluetoothFindFirstDevice(SearchParams, DeviceInfo);
      if (hFind <> 0) then begin
        repeat
          Inc(Ndx);
          SetLength(Devices, Ndx);
          Devices[Ndx - 1] := DeviceInfo.Address.ullLong;
     
          FillChar(DeviceInfo, DeviceInfoSize, 0);
          DeviceInfo.dwSize := DeviceInfoSize;
        until (not BluetoothFindNextDevice(hFind, DeviceInfo));
     
        BluetoothFindDeviceClose(hFind);
      end;
    end;
     
    function TBTDevice.GetAuthenticated: boolean;
    begin
      Result := boolean(GetDeviceInfo.fAuthenticated);
    end;
     
    function TBTDevice.GetClassOfDevice: cardinal;
    begin
      Result := GetDeviceInfo.ulClassofDevice;
    end;
     
    function TBTDevice.GetConnected: boolean;
    begin
      Result := boolean(GetDeviceInfo.fConnected);
    end;
     
    function TBTDevice.GetDeviceInfo: BLUETOOTH_DEVICE_INFO;
    var
      DeviceInfoSize: dword;
      Res: dword;
    begin
      DeviceInfoSize := SizeOf(BLUETOOTH_DEVICE_INFO);
     
      FillChar(Result, DeviceInfoSize, 0);
      with Result do begin
        dwSize := DeviceInfoSize;
        Address.ullLong := FAddress;
      end;
     
      Res := BluetoothGetDeviceInfo(FBTRadio.Handle, Result);
     
      if (Res <> ERROR_SUCCESS) then
        case Res of
          ERROR_REVISION_MISMATCH: raise BTException.Create(STR_ERROR_REVISION_MISMATCH_DEV);
          ERROR_INVALID_PARAMETER: raise BTException.Create(STR_ERROR_INVALID_PARAMETER_DEV);
        else
          RaiseLastOSError;
        end;
    end;
     
    function TBTDevice.GetLastSeen: TDateTime;
    begin
      Result := SystemTimeToDateTime(GetDeviceInfo.stLastSeen);
    end;
     
    function TBTDevice.GetLastUsed: TDateTime;
    begin
      Result := SystemTimeToDateTime(GetDeviceInfo.stLastUsed);
    end;
     
    function TBTDevice.GetName: string;
    begin
      Result := string(widestring(GetDeviceInfo.szName));
    end;
     
    function TBTDevice.GetRemembered: boolean;
    begin
      Result := boolean(GetDeviceInfo.fRemembered);
    end;
     
    procedure TBTDevice.SetOnAuthenticate(const Value: TBTAuthenticateEvent);
     
      procedure Unreg;
      begin
        if (FAuReg <> 0) then
          if (not BluetoothUnregisterAuthentication(FAuReg)) then
            RaiseLastOsError;
        FAuReg := 0;
        FOnAuthenticate := nil;
      end;
     
    begin
      if Assigned(Value) then begin
        Unreg;
        if (BluetoothRegisterForAuthentication(GetDeviceInfo, FAuReg, BTAuCallBack, Self) <> ERROR_SUCCESS) then begin
          FAuReg := 0;
          RaiseLastOSError;
        end;
        FOnAuthenticate := Value;
      end else
        Unreg;
    end;
     
    procedure TBTDevice.DoAuthenticate;
    var
      Pwd: string;
    begin
      if Assigned(FOnAuthenticate) then begin
        FOnAuthenticate(Self, Pwd);
        BluetoothSendAuthenticationResponse(FBTRadio.Handle, GetDeviceInfo, pwidechar(widestring(Pwd)));
      end;
    end;
     
    constructor TBTDevice.Create(const Addr: BTH_ADDR; const ABTRadio: TBTRadio);
    begin
      if (not Assigned(FBTRadio)) then raise BTException.Create(STR_ERROR_INVALID_PARAMETER);
     
      FAddress := Addr;
      FAuReg := 0;
      FBTRadio := ABTRadio;
      FOnAuthenticate := nil;
    end;
     
    destructor TBTDevice.Destroy;
    begin
      if Assigned(FOnAuthenticate) then OnAuthenticate := nil;
     
      inherited;
    end;
     
    procedure TBTDevice.Authenticate(const Pwd: string);
    var
      Res: dword;
      PPwd: pwidechar;
      PPwdLength: dword;
    begin
      if (Pwd = '') then begin
        PPwd := nil;
        PPwdLength := 0;
      end else begin
        PPwd := pwidechar(widestring(Pwd));
        PPwdLength := Length(WideString(Pwd));
      end;
     
      Res := BluetoothAuthenticateDevice(0, FBTRadio.Handle, GetDeviceInfo, PPwd, PPwdLength);
      if (Res <> ERROR_SUCCESS) then RaiseLastOsError;
    end;
     
    procedure TBTDevice.DisplayProperties;
    begin
      if (not BluetoothDisplayDeviceProperties(0, GetDeviceInfo)) then RaiseLastOsError;
    end;
     
    procedure TBTDevice.Remove;
    var
      Addr: BLUETOOTH_ADDRESS;
    begin
      Addr.ullLong := FAddress;
      if (BluetoothRemoveDevice(Addr) <> ERROR_SUCCESS) then RaiseLastOsError;
    end;
     
    procedure TBTDevice.Select(const FLags: TBTDeviceSelectFlags);
    var
      SelectParams: BLUETOOTH_SELECT_DEVICE_PARAMS;
      SelectParamsSize: dword;
      Res: dword;
    begin
      SelectParamsSize := SizeOf(BLUETOOTH_SELECT_DEVICE_PARAMS);
      FillChar(SelectParams, SelectParamsSize, 0);
      with SelectParams do begin
        dwSize := SelectParamsSize;
        fForceAuthentication := (dsForceAuthentication in Flags);
        fShowAuthenticated := (dsShowAuthenticated in Flags);
        fShowRemembered := (dsShowRemembered in Flags);
        fShowUnknown := (dsShowUnknown in Flags);
        fAddNewDeviceWizard := (dsAddNewDeviceWizard in Flags);
        fSkipServicesPage := (dsSkipServicesPage in Flags);
      end;
     
      if BluetoothSelectDevices(@SelectParams) then begin
        FAddress := BLUETOOTH_DEVICE_INFO(SelectParams.pDevices).Address.ullLong;
        BluetoothSelectDevicesFree(@SelectParams);
      end else begin
        Res := GetLastError;
        if (Res <> ERROR_CANCELLED) then
          case Res of
            ERROR_INVALID_PARAMETER: raise BTException.Create(STR_ERROR_INVALID_PARAMETER_SEL);
            ERROR_REVISION_MISMATCH: raise BTException.Create(STR_ERROR_REVISION_MISMATCH_SEL);
          else
            RaiseLastOSError;
          end;
      end;
    end;
     
    procedure TBTDevice.Update(const NewName: string);
    var
      DeviceInfo: BLUETOOTH_DEVICE_INFO;
      DeviceInfoSize: dword;
      Res: dword;
    begin
      DeviceInfoSize := SizeOf(BLUETOOTH_DEVICE_INFO);
      FillChar(DeviceInfo, DeviceInfoSize, 0);
      with DeviceInfo do begin
        dwSize := DeviceInfoSize;
        Address.ullLong := FAddress;
        lstrcpyw(szName, pwidechar(widestring(NewName)));
      end;
     
      Res := BluetoothUpdateDeviceRecord(DeviceInfo);
      if (Res <> ERROR_SUCCESS) then
        case Res of
          ERROR_INVALID_PARAMETER: raise BTException.Create(STR_ERROR_INVALID_PARAMETER_DEV);
          ERROR_REVISION_MISMATCH: raise BTException.Create(STR_ERROR_REVISION_MISMATCH_DEV);
        else
          RaiseLastOsError;
        end;
    end;
     
    end.

    {
      Copyright (C) 2006 Mike B. Petrichenko
      pmb_stv@mail.ru
      mobileservicesoft@yandex.ru
      ICQ: 190812766
      Phone: +7 (928) 324-58-24
             +7 (928) 819-46-40
     
      All Rights Reserved.
     
      Only for non commercial purpose.
    }
    unit BTExceptions;
     
    interface
     
    uses
      SysUtils;
     
    type
      BTException = class(Exception);
     
    implementation
     
    end.

    unit BthSdpDef;
     
    interface
     
    uses
      Windows;
     
    type
      SDP_LARGE_INTEGER_16 = record
        LowPart: Int64;
        HighPart: Int64;
      end;
      {$EXTERNALSYM SDP_LARGE_INTEGER_16}
      PSDP_LARGE_INTEGER_16 = ^SDP_LARGE_INTEGER_16;
      {$EXTERNALSYM PSDP_LARGE_INTEGER_16}
      LPSDP_LARGE_INTEGER_16 = PSDP_LARGE_INTEGER_16;
      {$EXTERNALSYM LPSDP_LARGE_INTEGER_16}
      TSdpLargeInteger = SDP_LARGE_INTEGER_16;
      PSdpLargeInteger = PSDP_LARGE_INTEGER_16;
     
      SDP_ULARGE_INTEGER_16 = record
        LowPart: Int64;
        HighPart: Int64;
      end;
      {$EXTERNALSYM SDP_ULARGE_INTEGER_16}
      PSDP_ULARGE_INTEGER_16 = ^SDP_ULARGE_INTEGER_16;
      {$EXTERNALSYM PSDP_ULARGE_INTEGER_16}
      LPSDP_ULARGE_INTEGER_16 = PSDP_ULARGE_INTEGER_16;
      {$EXTERNALSYM LPSDP_ULARGE_INTEGER_16}
      TSdpULargeInteger16 = SDP_ULARGE_INTEGER_16;
      PSdpULargeInteger16 = PSDP_ULARGE_INTEGER_16;
     
      NodeContainerType = (NodeContainerTypeSequence, NodeContainerTypeAlternative);
      TNodeContainerType = NodeContainerType;
     
      SDP_ERROR = Word;
      {$EXTERNALSYM SDP_ERROR}
      PSDP_ERROR = ^SDP_ERROR;
      {$EXTERNALSYM PSDP_ERROR}
      TSdpError = SDP_ERROR;
      PSdpError = PSDP_ERROR;
     
    type
      SDP_TYPE = DWORD;
      {$EXTERNALSYM SDP_TYPE}
      TSdpType = SDP_TYPE;
     
    const
      SDP_TYPE_NIL = $00;
      {$EXTERNALSYM SDP_TYPE_NIL}
      SDP_TYPE_UINT = $01;
      {$EXTERNALSYM SDP_TYPE_UINT}
      SDP_TYPE_INT = $02;
      {$EXTERNALSYM SDP_TYPE_INT}
      SDP_TYPE_UUID = $03;
      {$EXTERNALSYM SDP_TYPE_UUID}
      SDP_TYPE_STRING = $04;
      {$EXTERNALSYM SDP_TYPE_STRING}
      SDP_TYPE_BOOLEAN = $05;
      {$EXTERNALSYM SDP_TYPE_BOOLEAN}
      SDP_TYPE_SEQUENCE = $06;
      {$EXTERNALSYM SDP_TYPE_SEQUENCE}
      SDP_TYPE_ALTERNATIVE = $07;
      {$EXTERNALSYM SDP_TYPE_ALTERNATIVE}
      SDP_TYPE_URL = $08;
      {$EXTERNALSYM SDP_TYPE_URL}
      // 9 - 31 are reserved
      SDP_TYPE_CONTAINER = $20;
      {$EXTERNALSYM SDP_TYPE_CONTAINER}
     
    // allow for a little easier type checking / sizing for integers and UUIDs
    // ((SDP_ST_XXX & 0xF0) >> 4) == SDP_TYPE_XXX
    // size of the data (in bytes) is encoded as ((SDP_ST_XXX & 0xF0) >> 8)
     
    type
      SDP_SPECIFICTYPE = DWORD;
      {$EXTERNALSYM SDP_SPECIFICTYPE}
      TSdpSpecificType = SDP_SPECIFICTYPE;
     
    const
      SDP_ST_NONE = $0000;
      {$EXTERNALSYM SDP_ST_NONE}
     
      SDP_ST_UINT8 = $0010;
      {$EXTERNALSYM SDP_ST_UINT8}
      SDP_ST_UINT16 = $0110;
      {$EXTERNALSYM SDP_ST_UINT16}
      SDP_ST_UINT32 = $0210;
      {$EXTERNALSYM SDP_ST_UINT32}
      SDP_ST_UINT64 = $0310;
      {$EXTERNALSYM SDP_ST_UINT64}
      SDP_ST_UINT128 = $0410;
      {$EXTERNALSYM SDP_ST_UINT128}
     
      SDP_ST_INT8 = $0020;
      {$EXTERNALSYM SDP_ST_INT8}
      SDP_ST_INT16 = $0120;
      {$EXTERNALSYM SDP_ST_INT16}
      SDP_ST_INT32 = $0220;
      {$EXTERNALSYM SDP_ST_INT32}
      SDP_ST_INT64 = $0320;
      {$EXTERNALSYM SDP_ST_INT64}
      SDP_ST_INT128 = $0420;
      {$EXTERNALSYM SDP_ST_INT128}
     
      SDP_ST_UUID16 = $0130;
      {$EXTERNALSYM SDP_ST_UUID16}
      SDP_ST_UUID32 = $0220;
      {$EXTERNALSYM SDP_ST_UUID32}
      SDP_ST_UUID128 = $0430;
      {$EXTERNALSYM SDP_ST_UUID128}
     
    type
      _SdpAttributeRange = record
        minAttribute: Word;
        maxAttribute: Word;
      end;
      {$EXTERNALSYM _SdpAttributeRange}
      SdpAttributeRange = _SdpAttributeRange;
      {$EXTERNALSYM SdpAttributeRange}
      TSdpAttributeRange = SdpAttributeRange;
     
      SdpQueryUuidUnion = record
        case Integer of
          0: (uuid128: TGUID);
          1: (uuid32: ULONG);
          2: (uuid16: Word);
      end;
      TSdpQueryUuidUnion = SdpQueryUuidUnion;
     
      _SdpQueryUuid = record
        u: SdpQueryUuidUnion;
        uuidType: Word;
      end;
      {$EXTERNALSYM _SdpQueryUuid}
      SdpQueryUuid = _SdpQueryUuid;
      {$EXTERNALSYM SdpQueryUuid}
      TSdpQueryUuid = SdpQueryUuid;
     
    implementation
     
    end.
     

    {
      Copyright (C) 2006 Mike B. Petrichenko
      pmb_stv@mail.ru
      mobileservicesoft@yandex.ru
      ICQ: 190812766
      Phone: +7 (928) 324-58-24
             +7 (928) 819-46-40
     
      All Rights Reserved.
     
      Only for non commercial purpose.
    }
    unit BTRadio;
     
    interface
     
    uses
      Windows, BluetoothAPI;
     
    type
      TBTAddrArray = array of BTH_ADDR;
     
      TBTRadio = class
      private
        FAddress: BTH_ADDR;
        FClassOfDevice: cardinal;
        FHandle: THandle;
        FManufacturer: word;
        FName: string;
        FSubversion: word;
     
        function GetConnectable: boolean;
        function GetDiscoverable: boolean;
     
        procedure SetConnectable(const Value: boolean);
        procedure SetDiscoverable(const Value: boolean);
     
      public
        constructor Create(const AHandle: THandle);
        destructor Destroy; override;
     
        property Address: BTH_ADDR read FAddress;
        property ClassOfDevice: cardinal read FClassOfDevice;
        property Connectable: boolean read GetConnectable write SetConnectable;
        property Discoverable: boolean read GetDiscoverable write SetDiscoverable;
        property Handle: THandle read FHandle;
        property Manufacturer: word read FManufacturer;
        property Name: string read FName;
        property Subversion: word read FSubversion;
      end;
     
    function BTGetRadioByAddr(const Addr: BTH_ADDR): TBTRadio;
     
    procedure BTEnumRadios(var Radios: TBTAddrArray);
     
    implementation
     
    uses
      SysUtils, BTStrings, BTExceptions;
     
    function BTGetRadioByAddr(const Addr: BTH_ADDR): TBTRadio;
    var
      hFind: HBLUETOOTH_RADIO_FIND;
      SearchParams: BLUETOOTH_FIND_RADIO_PARAMS;
      hRadio: THandle;
      RadioInfo: BLUETOOTH_RADIO_INFO;
      RadioInfoSize: dword;
    begin
      Result := nil;
     
      SearchParams.dwSize := SizeOf(BLUETOOTH_FIND_RADIO_PARAMS);
     
      hFind := BluetoothFindFirstRadio(@SearchParams, hRadio);
      if (hFind <> 0) then begin
        repeat
          RadioInfoSize := SizeOf(BLUETOOTH_RADIO_INFO);
          FillChar(RadioInfo, RadioInfoSize, 0);
          RadioInfo.dwSize := RadioInfoSize;
     
          if (BluetoothGetRadioInfo(hRadio, RadioInfo) = ERROR_SUCCESS) then
            if (RadioInfo.address.ullLong = Addr) then begin
              Result := TBTRadio.Create(hRadio);
              Break;
            end;
     
          CloseHandle(hRadio);
        until (not BluetoothFindNextRadio(hFind, hRadio));
     
        BluetoothFindRadioClose(hFind);
      end;
    end;
     
    procedure BTEnumRadios(var Radios: TBTAddrArray);
    var
      hFind: HBLUETOOTH_RADIO_FIND;
      SearchParams: BLUETOOTH_FIND_RADIO_PARAMS;
      hRadio: THandle;
      Ndx: word;
      RadioInfo: BLUETOOTH_RADIO_INFO;
      RadioInfoSize: dword;
    begin
      Radios := nil;
      Ndx := 0;
     
      SearchParams.dwSize := SizeOf(BLUETOOTH_FIND_RADIO_PARAMS);
     
      hFind := BluetoothFindFirstRadio(@SearchParams, hRadio);
      if (hFind <> 0) then begin
        repeat
          RadioInfoSize := SizeOf(BLUETOOTH_RADIO_INFO);
          FillChar(RadioInfo, RadioInfoSize, 0);
          RadioInfo.dwSize := RadioInfoSize;
     
          if (BluetoothGetRadioInfo(hRadio, RadioInfo) = ERROR_SUCCESS) then begin
            Inc(Ndx);
            SetLength(Radios, Ndx);
            CopyMemory(@Radios[Ndx - 1], @RadioInfo, RadioInfoSize);
          end;
     
          CloseHandle(hRadio);
        until (not BluetoothFindNextRadio(hFind, hRadio));
     
        BluetoothFindRadioClose(hFind);
      end;
    end;
     
    function TBTRadio.GetConnectable: boolean;
    begin
      Result := BluetoothIsConnectable(FHandle);
    end;
     
    function TBTRadio.GetDiscoverable: boolean;
    begin
      Result := BluetoothIsDiscoverable(FHandle);
    end;
     
    procedure TBTRadio.SetConnectable(const Value: boolean);
    begin
      if (not BluetoothEnableIncomingConnections(FHandle, Value)) then raise BTException.Create(STR_ERROR_ENABLE_CONNECTION);
    end;
     
    procedure TBTRadio.SetDiscoverable(const Value: boolean);
    begin
      if (not BluetoothEnableDiscovery(FHandle, Value)) then raise BTException.Create(STR_ERROR_ENABLE_DISCOVERY);
    end;
     
    constructor TBTRadio.Create(const AHandle: THandle);
    var
      RadioInfo: BLUETOOTH_RADIO_INFO;
      RadioInfoSize: dword;
      Res: dword;
    begin
      FHandle := AHandle;
     
      RadioInfoSize := SizeOf(BLUETOOTH_RADIO_INFO);
      FillChar(RadioInfo, RadioInfoSize, 0);
      RadioInfo.dwSize := RadioInfoSize;
     
      Res := BluetoothGetRadioInfo(FHandle, RadioInfo);
      if (Res = ERROR_SUCCESS) then begin
        FAddress := RadioInfo.address.ullLong;
        FClassOfDevice := RadioInfo.ulClassofDevice;
        FManufacturer := RadioInfo.manufacturer;
        FName := string(widestring(RadioInfo.szName));
        FSubversion := RadioInfo.lmpSubversion;
     
      end else
        case Res of
          ERROR_INVALID_PARAMETER: raise BTException.Create(STR_ERROR_INVALID_PARAMETER);
          ERROR_REVISION_MISMATCH: raise BTException.Create(STR_ERROR_REVISION_MISMATCH);
     
        else
          RaiseLastOSError;
        end;
    end;
     
    destructor TBTRadio.Destroy;
    begin
      CloseHandle(FHandle);
     
      inherited;
    end;
     
    end.
     

    {
      Copyright (C) 2006 Mike B. Petrichenko
      pmb_stv@mail.ru
      mobileservicesoft@yandex.ru
      ICQ: 190812766
      Phone: +7 (928) 324-58-24
             +7 (928) 819-46-40
     
      All Rights Reserved.
     
      Only for non commercial purpose.
    }
    unit BTStrings;
     
    interface
     
    resourcestring
      STR_ERROR_INVALID_PARAMETER     = 'The hRadio or pRadioInfo parameter is NULL.';
      STR_ERROR_REVISION_MISMATCH     = 'The dwSize member of the BLUETOOTH_RADIO_INFO structure pointed to by pRadioInfo is not valid.';
      STR_ERROR_ENABLE_CONNECTION     = 'Unable change incoming connection state.';
      STR_ERROR_ENABLE_DISCOVERY      = 'Unable change discovery state';
      STR_ERROR_REVISION_MISMATCH_DEV = 'The size of the BLUETOOTH_DEVICE_INFO is not compatible. Check the dwSize member of the BLUETOOTH_DEVICE_INFO structure.';
      STR_ERROR_NOT_FOUND                  = 'The radio is not known by the system, or the Address member of the BLUETOOTH_DEVICE_INFO structure is all zeros.';
      STR_ERROR_INVALID_PARAMETER_DEV = 'The pbtdi parameter is NULL.';
      STR_ERROR_INVALID_PARAMETER_SEL = 'The pbtsdp is NULL.';
      STR_ERROR_REVISION_MISMATCH_SEL = 'The structure passed in as pbtsdp is of an unknown size.';
     
    implementation
     
    end.
