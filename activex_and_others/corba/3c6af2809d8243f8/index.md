---
Title: CORBA клиент-сервер
Date: 01.01.2007
---


CORBA клиент-сервер
===================

::: {.date}
01.01.2007
:::

    unit ufrmCorbaClient;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, SimpleCorbaServer_TLB, corbaObj, Grids;
     
    type
      TForm1 = class(TForm)
        GroupBox1: TGroupBox;
        Label2: TLabel;
        edtDatabase: TEdit;
        Label3: TLabel;
        edtUserName: TEdit;
        Label4: TLabel;
        edtPassword: TEdit;
        Button5: TButton;
        GroupBox2: TGroupBox;
        memoSQL: TMemo;
        GroupBox3: TGroupBox;
        Button6: TButton;
        grdCorbaData: TStringGrid;
        procedure ConnectClick(Sender: TObject);
        procedure ExecuteClick(Sender: TObject);
      private
        { Private declarations }
        FQueryServer: IQueryServer;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.ConnectClick(Sender: TObject);
    begin
      if not (assigned(FQueryServer)) then
        FQueryServer := TQueryServerCorbaFactory.CreateInstance('SimpleServer');
      FQueryServer.Login(edtDatabase.Text, edtUserName.Text, edtPassword.Text);
    end;
     
    procedure TForm1.ExecuteClick(Sender: TObject);
    var
      i, j: integer;
      CorbaData: OLEVariant;
    begin
      FQueryServer.SQL := memoSQL.Text;
      FQueryServer.Execute;
     
      grdCorbaData.ColCount := FQueryServer.FieldCount;
      grdCorbaData.RowCount := 0;
      j := 0;
     
      while not (FQueryServer.EOF) do
      begin
        inc(j);
        grdCorbaData.RowCount := j;
        CorbaData := (FQueryServer.Data);
        for i := 0 to FQueryServer.FieldCount - 1 do
        begin
          grdCorbaData.Cells[i + 1, j - 1] := CorbaData[i];
        end;
        FQueryServer.Next;
      end;
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
