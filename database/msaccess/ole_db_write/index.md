---
Title: Записываем в Access, используя OLE DB
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Записываем в Access, используя OLE DB
=====================================

    // Читаем Access`овскую базу используя ADO
    // Проверяе являеться ли файл .mdb Access
    // Записываем запись в базу
    // Нужны компаненты-
    //    TADOtable,TDataSource,TOpenDialog,TDBGrid,
    //    TBitBtn,TTimer,TEditTextBox
    program ADOdemo;
     
    uses Forms, uMain in 'uMain.pas' {frmMain};
     
    {$R *.RES}
     
    begin
      Application.Initialize;
      Application.CreateForm(TfrmMain, frmMain);
      Application.Run;
    end.
    ///////////////////////////////////////////////////////////////////
    unit uMain;
     
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Db, DBTables, ADODB, Grids, DBGrids, ExtCtrls, DBCtrls, StdCtrls, Buttons,
      ComObj;
     
    type
      TfrmMain = class(TForm)
        DBGridUsers: TDBGrid;
        BitBtnClose: TBitBtn;
        DSource1: TDataSource;
        EditTextBox: TEdit;
        BitBtnAdd: TBitBtn;
        TUsers: TADOTable;
        BitBtnRefresh: TBitBtn;
        Timer1: TTimer;
        Button1: TButton;
        procedure FormCreate(Sender: TObject);
        procedure ConnectToAccessDB(lDBPathName, lsDBPassword: string);
        procedure ConnectToMSAccessDB(lsDBName, lsDBPassword: string);
        procedure AddRecordToMSAccessDB;
        function CheckIfAccessDB(lDBPathName: string): Boolean;
        function GetDBPath(lsDBName: string): string;
        procedure BitBtnAddClick(Sender: TObject);
        procedure BitBtnRefreshClick(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
        function GetADOVersion: Double;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      frmMain: TfrmMain;
      Global_DBConnection_String: string;
    const
      ERRORMESSAGE_1 = 'No Database Selected';
      ERRORMESSAGE_2 = 'Invalid Access Database';
     
    implementation
     
    {$R *.DFM}
     
    procedure TfrmMain.FormCreate(Sender: TObject);
    begin
      ConnectToMSAccessDB('ADODemo.MDB', '123'); // DBName,DBPassword
    end;
     
    procedure TfrmMain.ConnectToMSAccessDB(lsDBName, lsDBPassword: string);
    var
      lDBpathName: string;
    begin
      lDBpathName := GetDBPath(lsDBName);
      if (Trim(lDBPathName) <> '') then
        begin
          if CheckIfAccessDB(lDBPathName) then
            ConnectToAccessDB(lDBPathName, lsDBPassword);
        end
      else
        MessageDlg(ERRORMESSAGE_1, mtInformation, [mbOK], 0);
    end;
     
    function TfrmMain.GetDBPath(lsDBName: string): string;
    var
      lOpenDialog: TOpenDialog;
    begin
      lOpenDialog := TOpenDialog.Create(nil);
      if FileExists(ExtractFileDir(Application.ExeName) + '\' + lsDBName) then
        Result := ExtractFileDir(Application.ExeName) + '\' + lsDBName
      else
        begin
          lOpenDialog.Filter := 'MS Access DB|' + lsDBName;
          if lOpenDialog.Execute then
            Result := lOpenDialog.FileName;
        end;
    end;
     
    procedure TfrmMain.ConnectToAccessDB(lDBPathName, lsDBPassword: string);
    begin
      Global_DBConnection_String :=
        'Provider=Microsoft.Jet.OLEDB.4.0;' +
        'Data Source=' + lDBPathName + ';' +
        'Persist Security Info=False;' +
        'Jet OLEDB:Database Password=' + lsDBPassword;
     
      with TUsers do
        begin
          ConnectionString := Global_DBConnection_String;
          TableName := 'Users';
          Active := True;
        end;
    end;
     
    // Check if it is a valid ACCESS DB File Before opening it.
     
    function TfrmMain.CheckIfAccessDB(lDBPathName: string): Boolean;
    var
      UnTypedFile: file of Byte;
      Buffer: array[0..19] of Byte;
      NumRecsRead: Integer;
      i: Integer;
      MyString: string;
    begin
      AssignFile(UnTypedFile, lDBPathName);
      reset(UnTypedFile, 1);
      BlockRead(UnTypedFile, Buffer, 19, NumRecsRead);
      CloseFile(UnTypedFile);
      for i := 1 to 19 do
        MyString := MyString + Trim(Chr(Ord(Buffer[i])));
      Result := False;
      if Mystring = 'StandardJetDB' then
        Result := True;
      if Result = False then
        MessageDlg(ERRORMESSAGE_2, mtInformation, [mbOK], 0);
    end;
     
    procedure TfrmMain.BitBtnAddClick(Sender: TObject);
    begin
      AddRecordToMSAccessDB;
    end;
     
    procedure TfrmMain.AddRecordToMSAccessDB;
    var
      lADOQuery: TADOQuery;
      lUniqueNumber: Integer;
    begin
      if Trim(EditTextBox.Text) <> '' then
        begin
          lADOQuery := TADOQuery.Create(nil);
          with lADOQuery do
            begin
              ConnectionString := Global_DBConnection_String;
              SQL.Text :=
                'SELECT Number from Users';
              Open;
              Last;
          // Generate Unique Number (AutoNumber in Access)
              lUniqueNumber := 1 + StrToInt(FieldByName('Number').AsString);
              Close;
          // Insert Record into MSAccess DB using SQL
              SQL.Text :=
                'INSERT INTO Users Values (' +
                IntToStr(lUniqueNumber) + ',' +
                QuotedStr(UpperCase(EditTextBox.Text)) + ',' +
                QuotedStr(IntToStr(lUniqueNumber)) + ')';
              ExecSQL;
              Close;
          // This Refreshes the Grid Automatically
              Timer1.Interval := 5000;
              Timer1.Enabled := True;
            end;
        end;
    end;
     
    procedure TfrmMain.BitBtnRefreshClick(Sender: TObject);
    begin
      Tusers.Active := False;
      Tusers.Active := True;
    end;
     
    procedure TfrmMain.Timer1Timer(Sender: TObject);
    begin
      Tusers.Active := False;
      Tusers.Active := True;
      Timer1.Enabled := False;
    end;
     
    function TfrmMain.GetADOVersion: Double;
    var
      ADO: OLEVariant;
    begin
      try
        ADO := CreateOLEObject('adodb.connection');
        Result := StrToFloat(ADO.Version);
        ADO := Null;
      except
        Result := 0.0;
      end;
    end;
     
    procedure TfrmMain.Button1Click(Sender: TObject);
    begin
      ShowMessage(Format('ADO Version = %n', [GetADOVersion]));
    end;
     
    end.

