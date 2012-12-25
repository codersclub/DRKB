---
Title: Как получить параметры Alias?
Date: 01.01.2007
---


Как получить параметры Alias?
=============================

::: {.date}
01.01.2007
:::

The following function uses the GetAliasParams method of TSession to get
the directory mapping for an alias:

    uses DbiProcs, DBiTypes;
     
    function GetDataBaseDir(const Alias: string): string;
    {* Will return the directory of the database given the alias
      (without trailing backslash) *}
    var
      sp: PChar;
      Res: pDBDesc;
    begin
      try
        New(Res);
        sp := StrAlloc(length(Alias) + 1);
        StrPCopy(sp, Alias);
        if DbiGetDatabaseDesc(sp, Res) = 0 then
          Result := StrPas(Res^.szPhyName)
        else
          Result := '';
      finally
        StrDispose(sp);
        Dispose(Res);
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    {
      Here's a demo to demonstrate how to get info about aliases in Delphi.
      First, create a new project with a listbox and 3 labels (called ListBox1,
      Label1, Label2, and Label3).  Then add an OnCreate event handler for the form
      with this code in it:
    }
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {
        GetAliasNames Populates a string list with the names of persistent
        Borland Database Engine (BDE) aliases.
      }
      Session.GetAliasNames(ListBox1.Items);
    end;
     
    { Now add an OnClick event for the Listbox: }
     
    procedure TForm1.ListBox1Click(Sender: TObject);
    var
      tStr: array[0..100] of char;
      Desc: DBDesc;
    {
     The DBDesc structure describes a database, using the following fields:
     
     szName    DBINAME  Specifies the database alias name.
     szText    DBINAME  Descriptive text.
     szPhyName  DBIPATH  Specifies the physical name/path.
     szDbType   DBINAME  Specifies the database type.
    }
    begin
      if ListBox1.Items.Count = 0 then
        exit;
      StrPLCopy(tStr, ListBox1.Items.Strings[ListBox1.ItemIndex], High(tStr));
      DbiGetDatabaseDesc(tStr, @Desc);
      with Desc do
      begin
        Label1.Caption := StrPas(Desc.szName);
        Label2.Caption := StrPas(Desc.szPhyName);
        Label3.Caption := StrPas(Desc.szDbType);
        Label4.Caption := StrPas(Desc.szText);
      end;
    end;
     
    // Now add the following to the 'uses' clause at the top of the unit:
     
    uses
      {...,}DB, DBTables, DBITypes, DBIProcs;
     
     
    {********************************************************************}
     
    {
      This Examples is just another approach to get infos about aliases
      Using 2 component (TListBox) and only use 1 uses clause (dbTables)
    }
     
    uses
      {...}, DBTables;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        ListBox2: TListBox;
     
    {..}
     
    implementation
     
    {..}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {Get Alias Names}
      Session.GetAliasNames(ListBox1.Items);
    end;
     
    procedure TForm1.ListBox1Click(Sender: TObject);
    begin
      ListBox2.Items.Clear;
      if ListBox1.Items.Count = 0 then
        Exit;
      {Get Alias Driver Names, like Standard, MsAccess, etc}
      ListBox2.Items.Add('DRIVER=' + Session.GetAliasDriverName(ListBox1.Items.Strings
          [ListBox1.ItemIndex]));
      {Get Alias Parameters and add it parameters into listbox2}
      Session.GetAliasParams(ListBox1.Items.Strings[ListBox1.ItemIndex], ListBox2.Items);
    end;
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
