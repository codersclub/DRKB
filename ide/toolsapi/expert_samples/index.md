---
Title: Еще примеры экспертов
Date: 12.12.2003
Author: Daniel Wischnewski
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Еще примеры экспертов
=====================

This article introduces you to the world of Delphi Experts. Delphi
Experts are DLLs, that will be loaded during the startup sequence of
Delphi. This article first appeared on
Delphi-PRAXiS http://www.delphipraxis.net/viewtopic.php?t=5300 in German.

NOTE: The techniques shown in this article are valid starting with
Delphi 3 or 4 and since Delphi 7 they are deprecated, however, still
fully suported by the Delphi IDE.

**Installation of a Delphi-IDE-Expert**

Every Delphi-Expert has to be registered in the Windows-Registry. For
each Delphi-Version installed on a machine, as well as for each user
using the machine, the Delphi-Expert has to be registered separately.

In the Registry the Delphi-Expert has to be registered under the
folowing key:

    HKCU\Software\Borland\Delphi\X.0\Experts

where the X has to be replaced by the appropriate Delphi-Version
supported. It may happen that the Experts key is not installed, in such
case you are required to create it.

Underneath the Experts key you have to create a string value for the
Delphi-Expert. The name must be unique. The value must point to the
Delphi-Expert DLL, including both complete path and file name of the
Delphi-Expert. Next time Delphi starts, the Expert will be loaded
automatically.

**The interface of the Delphi-Expert**

In order for the Delphi Expert to interact with the Delphi-IDE ist has
to export a function with the name ExpertEntryPoint, using the following
parameters:

    function InitExpert(ToolServices: TIToolServices; RegisterProc:
      TExpertRegisterProc; var Terminate: TExpertTerminateProc): Boolean; export;
      stdcall;

The first parameter ToolServices offers all "documented" interfaces to
the Delphi-IDE. The second parameter RegisterProc is used to load the
expert into the Delphi-IDE. The last parameter Teminate is used to
notify the Expert-DLL when it is about to be unloaded by the Delphi-IDE.

The InitExpert method returns True, if the Expert has loaded
successfully, otherwise it can eiter return False or raises an exception
to unload the DLL from the Delphi-IDE (see code sample for solution).

**The PlugIn class TIExpert**

Any Delphi-Expert must be derived from the class TIExpert, which is
declared in the unit ExptIntf. This class defines some abstract methods,
which must be implemented by each PlugIn: GetName, GetAuthor,
GetComment, GetPage, GetGlyph (different for Windows and Linux),
GetStyle, GetState, GetIDString, GetMenuText and Execute. The purpose of
each method is explained in the source code below.

**The simplest Delphi-Expert**

This Delphi-Expert want do much good, however, it shows you the basic
way of getting the job done. It will show an entry in the Help menu
(default behavior). Once the user clicks the menu item the method
Execute from the Expert will be called. The following points must be
respected in order to get the expert working:

- The method GetState must return [esEnabled]
- The method GetStyle must return esStandard
- The method GetMenuText returns the text to be shown in the Help menu
- The method Execute defines the expert action upon activation


The Library Source Code (DelphiPlugI.dpr)

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     * App. Name : DelphiPlug
     * Autor     : Daniel Wischnewski
     * Copyright : Copyright © 2000-2003 by gate(n)etwork GmbH. All Right Reserved.
     * Urheber   : Daniel Wischnewski
     *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
     
    library DelphiPlug;
     
    { Important note about DLL memory management: ShareMem must be the
      first unit in your library's USES clause AND your project's (select
      Project-View Source) USES clause if your DLL exports any procedures or
      functions that pass strings as parameters or function results. This
      applies to all strings passed to and from your DLL--even those that
      are nested in records and classes. ShareMem is the interface unit to
      the BORLNDMM.DLL shared memory manager, which must be deployed along
      with your DLL. To avoid using BORLNDMM.DLL, pass string information
      using PChar or ShortString parameters. }
     
    uses
      ShareMem,
      ExptIntf,
      uPlugIn in 'uPlugIn.pas';
     
    {$R *.res}
     
    exports
      InitExpert name ExpertEntryPoint;
     
    begin
    end.
     
    The Unit Source Code (uPlugIn.pas)
     
    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     * Unit Name : uPlugIn
     * Autor     : Daniel Wischnewski
     * Copyright : Copyright © 2000-2003 by gate(n)etwork GmbH. All Right Reserved.
     * Urheber   : Daniel Wischnewski
     *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
     
    unit uPlugIn;
     
    interface
     
    uses
      ToolIntf, EditIntf, ExptIntf, VirtIntf, Windows, Messages;
     
    const
      MIdx_Main = $0001;
      MIdx_ShowItems = $0002;
      MIdx_RunCommand = $0003;
     
    type
      TDelphiPlug = class(TIExpert)
      private
      protected
      public
        // abstract methods to be overriden
        { Expert UI strings }
        function GetName: string; override; stdcall;
        function GetAuthor: string; override; stdcall;
        function GetComment: string; override; stdcall;
        function GetPage: string; override; stdcall;
    {$IFDEF MSWINDOWS}
        function GetGlyph: HICON; override; stdcall;
    {$ENDIF}
    {$IFDEF LINUX}
        function GetGlyph: Cardinal; override; stdcall;
    {$ENDIF}
        function GetStyle: TExpertStyle; override; stdcall;
        function GetState: TExpertState; override; stdcall;
        function GetIDString: string; override; stdcall;
        function GetMenuText: string; override; stdcall;
        { Launch the Expert }
        procedure Execute; override; stdcall;
      end;
     
    function InitExpert(ToolServices: TIToolServices; RegisterProc:
      TExpertRegisterProc; var Terminate: TExpertTerminateProc): Boolean; export;
    stdcall;
     
    implementation
     
    uses
      SysUtils, ShellAPI;
     
    function InitExpert(ToolServices: TIToolServices; RegisterProc:
      TExpertRegisterProc; var Terminate: TExpertTerminateProc): Boolean; export;
      stdcall;
    var
      DelphiPlug: TDelphiPlug;
    begin
      Result := True;
      try
        // assign tools services
        ExptIntf.ToolServices := ToolServices;
        // create the Delphi-Plug
        DelphiPlug := TDelphiPlug.Create;
        // register with Delphi
        RegisterProc(DelphiPlug);
      except
        // kill assistant
        ToolServices.RaiseException(ReleaseException);
      end;
    end;
     
    { TDelphiPlug }
     
    procedure TDelphiPlug.Execute;
    begin
      // en:
      //   Execute will be called, whenever the user clicks on the menu entry in the
      //   help menu
      MessageBox(ToolServices.GetParentHandle, 'How may I help you?', 'Hmm',
        MB_ICONQUESTION + MB_OK);
    end;
     
    function TDelphiPlug.GetAuthor: string;
    begin
      // en:
      //   returns the name of the author of the plugin
      Result := 'sakura (Daniel Wischnewski)';
    end;
     
    function TDelphiPlug.GetComment: string;
    begin
      // en:
      //   I got no idea where this comment will be displayed, ever.
      Result := 'A simple Delphi-PlugIn example.';
    end;
     
    {$IFDEF MSWINDOWS}
     
    function TDelphiPlug.GetGlyph: HICON;
    begin
      // en:
      //   an icon handle for the entry in the help menu
      Result := NOERROR;
    end;
    {$ENDIF}
    {$IFDEF LINUX}
     
    function TDelphiPlug.GetGlyph: Cardinal;
    begin
      // en:
      //   an icon handle for the entry in the help menu
      Result := NOERROR;
    end;
    {$ENDIF}
     
    function TDelphiPlug.GetIDString: string;
    begin
      // en:
      //   id of the expert
      Result := 'DelphiPlugSampleI';
    end;
     
    function TDelphiPlug.GetMenuText: string;
    begin
      // en:
      //   this text will be schon in the help menu. each time the menu drops down,
      //   this method will be called.
      //   NOTE:
      //     the method GetState must return esStandard, otherwise the help menu
      //     entry will not be generated and shown
      Result := 'You will find me in the help menu';
    end;
     
    function TDelphiPlug.GetName: string;
    begin
      // en:
      //   this name must be unique
      Result := 'sakura_DelphiPlugSample';
    end;
     
    function TDelphiPlug.GetPage: string;
    begin
      // en:
      //   interesting to experts expanding the default dialogs of the Delphi-IDE
      Result := '';
    end;
     
    function TDelphiPlug.GetState: TExpertState;
    begin
      // en:
      //   returns a set of states
      //   possible values: esEnabled, esChecked
      Result := [esEnabled];
    end;
     
    function TDelphiPlug.GetStyle: TExpertStyle;
    begin
      // en:
      //   returns the type of expert
      Result := esStandard;
    end;
     
    end.

