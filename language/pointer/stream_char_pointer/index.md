---
Title: Взять один символ из потока памяти
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Взять один символ из потока памяти
==================================

    unit MsFormR;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        OpenDialog1: TOpenDialog;
        SaveDialog1: TSaveDialog;
        Memo1: TMemo;
        ListBox1: TListBox;
        Panel1: TPanel;
        Button1: TButton;
        Button2: TButton;
        Splitter1: TSplitter;
        procedure FormCreate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        MemStr1: TMemoryStream;
      public
        procedure ShowMemStr;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      MemStr1 := TMemoryStream.Create;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Str1: TFileStream;
    begin
      OpenDialog1.Filter :=
        'Any file (*.*)|*.*';
      OpenDialog1.DefaultExt := '*';
      if OpenDialog1.Execute then
      begin
        Str1 := TFileStream.Create (
          OpenDialog1.Filename, fmOpenRead);
        try
          MemStr1.LoadFromStream (Str1);
          ShowMemStr;
          Button2.Enabled := true;
        finally
          Str1.Free;
        end;
      end;
    end;
     
    procedure TForm1.ShowMemStr;
    begin
      Memo1.Lines.LoadFromStream (MemStr1);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    const
      ndx: LongInt = 1;
    var
      pch:  PChar;
      tmpC: Char;
    begin
      pch := MemStr1.Memory;
      tmpC := pch[ndx];
      pch[ndx] := #0;
      ListBox1.Items.SetText(MemStr1.Memory);
      pch[ndx] := tmpC;
     
      if ndx < MemStr1.Size then
        Inc(ndx)
      else
        Button2.Enabled := False;
    end;
     
    end.

