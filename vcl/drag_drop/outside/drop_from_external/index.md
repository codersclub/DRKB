---
Title: Как сделать Drag & Drop из чужого приложения?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сделать Drag & Drop из чужого приложения?
=============================================

    {
      The following example demonstrates the Drag&Drop machanism from an external
      application (Wordpad, Microsoft,..) to a TMemo in your own application.
     }
     
    unit TMemoDragDropFrm;
     
    { ****************************************************************
      Source File Name :  TMemoDragDropFrm.pas
      Typ              :  Hauptformular
      Autor            :  Andreas Kosch
      Compiler         :  Delphi 4.02 CSS
      Betriebssystem   :  Windows 98
      Beschreibung     :  Text via OLE Drag&Drop ubernehmen aus einer
                          anderen Anwendung (wie zum Beispiel WordPad)
                          ubernehmen.
      16.01.2003: Test mit Delphi 7 und Microsoft Word XP unter Windowx XP
     **************************************************************** }
     { Comments by Thomas Stutz }
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ComCtrls, ActiveX, ShlObj, ComObj, StdCtrls;
     
    type
      // TForm1's declaration indicates that it's a TForm and that
      // it supports the IDropTarget interface:
     
     {
     
      IDropTarget
     
      Any application wanting to accept drop operations must
      implement the IDropTarget interface.
     
      Methods of the IDropTarget interface:
     
      DragEnter
        Dragged item has just been moved into the application's window,
        return the relevant icon.
     
      DragOver
        Dragged item is being moved over the application's window,
        return the relevant icon.
     
      DragLeave
        Dragged item has just moved out of the application's window.
     
      Drop
        The dragged item has been dropped on this application.
     
      }
     
      TForm1 = class(TForm, IDropTarget)
        Memo1: TMemo;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        // IDropTarget
        function DragEnter(const dataObj: IDataObject;
                           grfKeyState: Longint;
                           pt: TPoint;
                           var dwEffect: Longint): HResult; stdcall;
        function DragOver(grfKeyState: Longint;
                          pt: TPoint;
                          var dwEffect: Longint): HResult; stdcall;
        function DragLeave: HResult; stdcall;
        function Drop(const dataObj: IDataObject;
                      grfKeyState: Longint; pt: TPoint;
                      var dwEffect: Longint): HResult; stdcall;
       // IUnknown
       // Ignore referance counting
       function _AddRef: Integer; stdcall;
       function _Release: Integer; stdcall;
     
      public
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      ShellAPI;
     
     
    // In the OnCreate event handler, two important methods are called.
    // First, OleInitalize is called. This initializes the OLE libraries and should always be
    // called before your application uses any OLE functions.
    // RegisterDragDrop registers the window as a valid drop target.
    // If this isn't called, the window will never receive any drop events.
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      OleInitialize(nil);
      {Allow window to accept drop events}
      OleCheck(RegisterDragDrop(Handle, Self));
      { Execute Wordpad for testing }
      ShellExecute(Handle, 'open', 'wordpad', 'c:\Test.doc', nil, SW_SHOW);
    end;
     
    // OnDestroy does the exact opposite. It calls RevokeDropTarget to indicate that
    // drop events are no longer accepted.
    // It then calls OleUninitialize, since the application is finished using all OLE functions.
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      {Finished accepting drops}
      RevokeDragDrop(Handle);
      OleUninitialize;
    end;
     
    {-----------------------------------------------------------------}
    { IDropTarget-Implementierung                                     }
    {-----------------------------------------------------------------}
    function TForm1.DragEnter(const dataObj: IDataObject;
      grfKeyState: Longint;
      pt: TPoint;
      var dwEffect: Longint): HResult;
    begin
      dwEffect := DROPEFFECT_COPY;
      Result  := S_OK;
    end;
     
    function TForm1.DragOver(grfKeyState: Longint;
      pt: TPoint;
      var dwEffect: Longint): HResult;
    begin
      dwEffect := DROPEFFECT_COPY;
      Result := S_OK;
    end;
     
    function TForm1.DragLeave: HResult;
    begin
      Result := S_OK;
    end;
     
    function TForm1._AddRef: Integer;
    begin
       Result := 1;
    end;
     
    function TForm1._Release: Integer;
    begin
       Result := 1;
    end;
     
    function TForm1.Drop(const dataObj: IDataObject;
      grfKeyState: Longint;
      pt: TPoint;
      var dwEffect: Longint): HResult;
    var
      aFmtEtc: TFORMATETC;
      aStgMed: TSTGMEDIUM;
      pData: PChar;
    begin
      {Make certain the data rendering is available}
      if (dataObj = nil) then
        raise Exception.Create('IDataObject-Pointer is not valid!');
      with aFmtEtc do
      begin
        cfFormat := CF_TEXT;
        ptd := nil;
        dwAspect := DVASPECT_CONTENT;
        lindex := -1;
        tymed := TYMED_HGLOBAL;
      end;
      {Get the data}
      OleCheck(dataObj.GetData(aFmtEtc, aStgMed));
      try
        {Lock the global memory handle to get a pointer to the data}
        pData := GlobalLock(aStgMed.hGlobal);
        { Replace Text }
        Memo1.Text := pData;
      finally
        {Finished with the pointer}
        GlobalUnlock(aStgMed.hGlobal);
        {Free the memory}
        ReleaseStgMedium(aStgMed);
      end;
      Result := S_OK;
    end;
     
    end.

