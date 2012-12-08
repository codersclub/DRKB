---
Title: Как написать Outlook AddIn?
Date: 01.01.2007
---


Как написать Outlook AddIn?
===========================

::: {.date}
01.01.2007
:::

    { 
      1.  Create an ActiveX-Library 
      Save the project as e.g. "OLAddIn.dpr" 
     
      2.Create an automation object 
      Call the CoClass e.g. "AddIn" 
      Save the Unit as "AddIn.pas" 
     
      3.  Add to the uses clause 
      - AddInDesignerObjects_TLB 
      - Outlook_TLB 
     
    } 
     
    -     procedure OnConnection(const Application: IDispatch; ConnectMode: ext_ConnectMode; 
                               const AddInInst: IDispatch; var custom: PSafeArray); safecall; 
    -     procedure OnDisconnection(RemoveMode: ext_DisconnectMode; var custom: PSafeArray); safecall; 
    -     procedure OnAddInsUpdate(var custom: PSafeArray); safecall; 
    -     procedure OnStartupComplete(var custom: PSafeArray); safecall; 
    -     procedure OnBeginShutdown(var custom: PSafeArray); safecall; 
     
    { 
      and complete the class by pressing Ctrl-Shft-C 
     
      4. Step 
      Register the COM-object with "run / register ActiveX Server" 
      Register the AddIn, so that the Addin will be recognized by Outlook 
      - Create a new key: HKEY_CURRENT_USER\Software\Microsoft\Office\Outlook\Addins\OLAddIn.AddIn 
      - create a DWOrd "LoadBehavior" with the value 3 
     
      5.
      Compile the AddIn 
      Start Outllok 
     
      Sourcecode 
     
      ********************************************************************************* 
    } 
     
     
    library OLAddIn; 
     
    uses 
      ComServ, 
      OLAddIn_TLB in 'OLAddIn_TLB.pas', 
      AddIn in 'AddIn.pas' {AddIn: CoClass}; 
     
    exports 
      DllGetClassObject, 
      DllCanUnloadNow, 
      DllRegisterServer, 
      DllUnregisterServer; 
     
    {$R *.TLB} 
     
    {$R *.RES} 
     
    begin 
    end. 

    unit AddIn; 
     
    {$WARN SYMBOL_PLATFORM OFF} 
     
    interface 
     
    uses 
      ComObj, ActiveX, OLAddIn_TLB, StdVcl, AddinDesignerObjects_TLB, Outlook_TLB; 
     
    type 
      TAddIn = class(TAutoObject, IAddIn, IDTExtensibility2) 
      protected 
        { Protected declarations } 
        procedure OnConnection(const Application: IDispatch; ConnectMode: ext_ConnectMode; 
                               const AddInInst: IDispatch; var custom: PSafeArray); safecall; 
        procedure OnDisconnection(RemoveMode: ext_DisconnectMode; var custom: PSafeArray); safecall; 
        procedure OnAddInsUpdate(var custom: PSafeArray); safecall; 
        procedure OnStartupComplete(var custom: PSafeArray); safecall; 
        procedure OnBeginShutdown(var custom: PSafeArray); safecall; 
      end; 
     
    implementation 
     
    uses ComServ, Dialogs; 
     
    { TAddIn } 
     
    procedure TAddIn.OnAddInsUpdate(var custom: PSafeArray); 
    begin 
     
    end; 
     
    procedure TAddIn.OnBeginShutdown(var custom: PSafeArray); 
    begin 
     
    end; 
     
    procedure TAddIn.OnConnection(const Application: IDispatch; 
      ConnectMode: ext_ConnectMode; const AddInInst: IDispatch; 
      var custom: PSafeArray); 
    begin 
      // To show, that the AddIn has started just say anything 
      ShowMessage('Das AddIn wurde gestartet'); 
    end; 
     
    procedure TAddIn.OnDisconnection(RemoveMode: ext_DisconnectMode; 
      var custom: PSafeArray); 
    begin 
     
    end; 
     
    procedure TAddIn.OnStartupComplete(var custom: PSafeArray); 
    begin 
     
    end; 
     
    initialization 
      TAutoObjectFactory.Create(ComServer, TAddIn, Class_AddIn, 
        ciMultiInstance, tmApartment); 
    end. 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
