---
Title: Копирование и вставка данных своего формата из буфера обмена
Date: 01.01.2007
---


Копирование и вставка данных своего формата из буфера обмена
============================================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

    // The TClipboard provides easy clipboard access. But what if you 
    // want to add (several) custom defined items to the clipboard? 
     
    // For all actions is the unit Clipboard required. 
    uses Clipboard;
     
    // First you have to register your own ClipBoard format 
    // Zuerst registrieren wir unser eigenes ClipBoard Format 
    const
      MyClipboardFormatStr = 'MyData';
     
    var
      MyClpFormat: integer;
     
      MyClpFormat := RegisterClipboardFormat(MyClipboardFormatStr);
     
    { The variable SLMClpFormat will contain a unique format handle for 
      your own clipboard format. 
     
      Die Variable SLMClpFormat enthalt ein einzigartiges Format Handle 
      fur unser ClipBoard Format. 
    }
     
    procedure IncPointer(var p: Pointer; increment: Integer);
    begin
      p := PChar(p) + Increment;
    end;
    
    // Say you have a data record defined as: 
    // Definiere zuerst etwa einen solchen Daten Record: 
    type
      PMyDataRec = ^TMyDataRec;
      TMyDataRec = record
        Name: string[50];
        Value: Integer;
      end;
    
    { Furthermore let's say the data records are stored in a Listbox 
      and shall be copied to a list box. 
     
      Angenommen, die Daten Records sind in einer ListBox gespeichert und 
      sollen in eine ListBox kopiert werden. 
    }
     
    // Copy like this: 
    procedure TForm1.CopyItems;
    var
      i: integer;
      dh: THandle;
      ic: integer;
      p: Pointer;
      pi: pInteger;
    begin
      // get number of items to be copied 
      // Die Anzahl zu kopierenden Items 
      ic := List1.SelCount;
      dh := GlobalAlloc(GMEM_FIXED or GMEM_ZEROINIT,
            (SizeOf(TMyDataRec) * ic) + SizeOf(Integer));
      { allocate memory for all items plus for a integer variable giving you the number of 
        copied items }
      p   := GlobalLock(dh);    { Lock the allocated memory }
      pi  := pInteger(p);
      pi^ := ic;              { write number of items to allocated memory }
      IncPointer(p, SizeOf(Integer)); { increment the pointer behind the written data }
      // You don't have to create an instance of clipboard, this is done automatically 
     
      for i := 1 to List1.Items.Count do { check all items if they are selected }
      begin
        if List1.Items[i - 1].Selected then
        begin
          { This one is selected -> copy it o the clipboard }
          PMyDataRec(p)^ := PMyDataRec(List1.Items[i - 1].Data)^;
          { of course data must point to a TMyDataRec }
          IncPointer(p, SizeOf(TMyDataRec));
          { increment the pointer behind the written data }
        end;
      end;
    
      // You have now filled the allocated memory with all items that shall be copied. 
      // Now you can put them to the clipboard 
      Clipboard.Open;  { Open the clipboard will prevent overwriting of so far copied items }
      Clipboard.Clear; { Clear the clipboard first }
      Clipboard.SetAsHandle(MyClpFormat, Dh);  { Copy to clipboard }
      Clipboard.Close;  { finally close the clipboard }
      GlobalUnlock(dh);
      { and unlock the allocate memory. But don't free it, it will be used by the clipboard }
    
      if ic = 0 then
        GlobalFree(dh);    { You can free it if you haven't copied anything }
    end;
    
    // Check first if your items are still available before pasting them from the clipbard 
     
    if Clipboard.HasFormat(MyClpFormat) then
    begin
      Form1.Paste1.Enabled := True;   { Yes, they are still available }
    end;
    
    // And this is, how you paste them after Paste1 is clicked 
    procedure TMDIForm.Paste1Click(Sender: TObject);
    var
      dh: THandle;
      pdr: PSLMDataRec;
      i, ic: integer;
      p: Pointer;
      pi: pInteger;
      li: TListItem;
    begin
      if Clipboard.HasFormat(MyClpFormat) then
      // We have already checked, but maybe another application has overwritten the 
      // clipboard in between.... 
      begin
        ClipBoard.Open;       { First open the clipboard again }
        dh := Clipboard.GetAsHandle(MyClpFormat); { Catch the handle to the stored items }
        p  := GlobalLock(dh);  { and lock it }
        pi := pInteger(p);    { The first item is an integer giving the number of items }
        ic := pi^;            { so get the number of items }
        IncPointer(p, SizeOf(Integer)); { increment the pointer behind the read data }
        for i := 1 to ic do   { get all copied items one after another }
        begin
          li   := List1.Items.Add;  { first create a new listbox item }
          pdr  := New(PMyDataRec); { Then create a new pointer to a TMyDataRec }
          pdr^ := PMyDataRec(p)^; { and fill it with data from the clipboard }
          IncPointer(p, SizeOf(TSLMDataRec));
          { increment the pointer behind the written data }
    
          li.Data    := pdr;  { Set the data pointer of the list item to the new record }
          LI.Caption := pdr^.Name;  { Let the item display the record field "Name" }
    
          // You can of course add more record fields if the item has subitems: 
          LI.SubItems.Add(IntToStr(Value));
        end;    { All data retrieved from clipboard }
        Clipboard.Close;  { Close it }
        GlobalUnlock(dh);
        { and unlock the pointer, but don't free it. This will be done by the clipboard itself, 
          if necessary }
      end;
    end;


------------------------------------------------------------------------

Вариант 2:

Author: Xavier Pacheco and Steve Teixeira

Date: 12.12.2000

    {
    Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
    unit cbdata;
    interface
    uses
      SysUtils, Windows, clipbrd;
     
    const
      DDGData = 'CF_DDG'; // constant for registering the clipboard format.
    
    type
     
      // Record data to be stored to the clipboard
     
      TDataRec = packed record
        LName: string[10];
        FName: string[10];
        MI: string[2];
        Age: Integer;
        BirthDate: TDateTime;
      end;
     
      { Define an object around the TDataRec that contains the methods
        for copying and pasting the data to and from the clipboard }
      TData = class
      public
        Rec: TDataRec;
        procedure CopyToClipBoard;
        procedure GetFromClipBoard;
      end;
     
    var
      CF_DDGDATA: word; // Receives the return value of RegisterClipboardFormat().
     
    implementation
     
    procedure TData.CopyToClipBoard;
    { This function copies the contents of the TDataRec field, Rec, to the
      clipboard as both binary data, as text. Both formats will be
      available from the clipboard }
    const
      CRLF = #13#10;
    var
    Data: THandle;
      DataPtr: Pointer;
      TempStr: string[50];
    begin
      // Allocate SizeOf(TDataRec) bytes from the heap
      Data := GlobalAlloc(GMEM_MOVEABLE, SizeOf(TDataRec));
      try
        // Obtain a pointer to the first byte of the allocated memory
        DataPtr := GlobalLock(Data);
        try
          // Move the data in Rec to the memory block
          Move(Rec, DataPtr^, SizeOf(TDataRec));
          { Clipboard.Open must be called if multiple clipboard formats are
            being copied to the clipboard at once. Otherwise, if only one
            format is being copied the call isn't necessary }
          ClipBoard.Open;
          try
            // First copy the data as its custom format
            ClipBoard.SetAsHandle(CF_DDGDATA, Data);
            // Now copy the data as text format
            with Rec do
              TempStr := FName + CRLF + LName + CRLF + MI + CRLF + IntToStr(Age) +
                CRLF +
                DateTimeToStr(BirthDate);
            ClipBoard.AsText := TempStr;
            { If a call to Clipboard.Open is made you must match it
              with a call to Clipboard.Close }
          finally
            Clipboard.Close
          end;
        finally
          // Unlock the globally allocated memory
          GlobalUnlock(Data);
        end;
      except
        { A call to GlobalFree is required only if an exception occurs.
          Otherwise, the clipboard takes over managing any allocated
          memory to it.}
        GlobalFree(Data);
        raise;
      end;
    end;
     
    procedure TData.GetFromClipBoard;
    { This method pastes memory saved in the clipboard if it is of the
      format CF_DDGDATA. This data is stored in the TDataRec field of
      this object. }
    var
      Data: THandle;
      DataPtr: Pointer;
      Size: Integer;
    begin
      // Obtain a handle to the clipboard
      Data := ClipBoard.GetAsHandle(CF_DDGDATA);
      if Data = 0 then
        Exit;
      // Obtain a pointer to the memory block referred to by Data
      DataPtr := GlobalLock(Data);
      try
        // Obtain the size of the data to retrieve
        if SizeOf(TDataRec) > GlobalSize(Data) then
          Size := GlobalSize(Data)
        else
          Size := SizeOf(TDataRec);
        // Copy the data to the TDataRec field
        Move(DataPtr^, Rec, Size)
      finally
        // Free the pointer to the memory block.
        GlobalUnlock(Data);
      end;
    end;
     
    initialization
      // Register the custom clipboard format
      CF_DDGDATA := RegisterClipBoardFormat(DDGData);
    end.

    {
    Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
     
    unit MainFrm;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, clipbrd, Mask, ComCtrls;
    
    type
      TMainForm = class(TForm)
        edtFirstName: TEdit;
        edtLastName: TEdit;
        edtMI: TEdit;
        btnCopy: TButton;
        btnPaste: TButton;
        meAge: TMaskEdit;
        btnClear: TButton;
        lblFirstName: TLabel;
        lblLastName: TLabel;
        lblMI: TLabel;
        lblAge: TLabel;
        lblBirthDate: TLabel;
        memAsText: TMemo;
        lblCustom: TLabel;
        lblText: TLabel;
        dtpBirthDate: TDateTimePicker;
        procedure btnCopyClick(Sender: TObject);
        procedure btnPasteClick(Sender: TObject);
        procedure btnClearClick(Sender: TObject);
      end;
     
    var
      MainForm: TMainForm;
     
    implementation
    uses cbdata;
     
    {$R *.DFM}
     
    procedure TMainForm.btnCopyClick(Sender: TObject);
    // This method copies the data in the form's controls onto the clipboard
    var
      DataObj: TData;
    begin
      DataObj := TData.Create;
      try
        with DataObj.Rec do
        begin
          FName := edtFirstName.Text;
          LName := edtLastName.Text;
          MI := edtMI.Text;
          Age := StrToInt(meAge.Text);
          BirthDate := dtpBirthDate.Date;
          DataObj.CopyToClipBoard;
        end;
      finally
        DataObj.Free;
      end;
    end;
     
    procedure TMainForm.btnPasteClick(Sender: TObject);
    { This method pastes CF_DDGDATA formatted data from the clipboard to
      the form's controls. The text version of this data is copied to the
      form's TMemo component. }
    var
      DataObj: TData;
    begin
      btnClearClick(nil);
      DataObj := TData.Create;
      try
        // Check if the CF_DDGDATA format is available
        if ClipBoard.HasFormat(CF_DDGDATA) then
          // Copy the CF_DDGDATA formatted data to the form's controls
          with DataObj.Rec do
          begin
            DataObj.GetFromClipBoard;
            edtFirstName.Text := FName;
            edtLastName.Text := LName;
            edtMI.Text := MI;
            meAge.Text := IntToStr(Age);
            dtpBirthDate.Date := BirthDate;
          end;
      finally
        DataObj.Free;
      end;
      // Now copy the text version of the data to form's TMemo component.
      if ClipBoard.HasFormat(CF_TEXT) then
        memAsText.PasteFromClipBoard;
    end;
     
    procedure TMainForm.btnClearClick(Sender: TObject);
    var
      i: integer;
    begin
      // Clear the contents of all controls on the form
      for i := 0 to ComponentCount - 1 do
        if Components[i] is TCustomEdit then
          TCustomEdit(Components[i]).Text := '';
    end;
     
    end.
