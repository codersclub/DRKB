---
Title: Drag & Drop c Explorer
Author: Aleksey
Date: 01.01.2007
---


Drag & Drop c Explorer
======================

::: {.date}
01.01.2007
:::

    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs,
     
      ComCtrls;
     
    type
     
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
        procedure FileIsDropped(var Msg: TMessage); message WM_DropFiles;
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
    uses
      shellapi;
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     
      DragAcceptFiles(Handle, True);
    end;
     
    procedure TForm1.FileIsDropped(var Msg: TMessage);
    var
     
      hDrop: THandle;
      fName: array[0..254] of CHAR;
      NumberOfFiles: INTEGER;
      fCounter: INTEGER;
      Names: string;
    begin
     
      hDrop := Msg.WParam;
      NumberOfFiles := DragQueryFile(hDrop, -1, fName, 254);
      Names := '';
      for fCounter := 1 to NumberOfFiles do
      begin
        DragQueryFile(hDrop, fCounter, fName, 254);
        // Здесь вы получаете один к одному имя вашего файла
     
        Names := Names + #13#10 + fName;
      end;
     
      ShowMessage('Бросаем ' + IntToStr(NumberOfFiles) + ' файла(ов) : ' + Names);
      DragFinish(hDrop);
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Aleksey

    {Так можно заставить окно принимать файлы, перетаскиваемые из проводника}
    {ОБЯЗАТЕЛЬНО ПОМЕСТИТЕ В СЕКЦИЮ PRIVATE СТРОКИ
     
    procedure CreateParams(var Params: TCreateParams); override;
    procedure WMDropFiles(var Message: TWMDropFiles); message WM_DROPFILES;
    и не забудьте - ShellAPI поместить в uses}
     
    procedure TForm1.CreateParams(var Params: TCreateParams);
    begin
     
      inherited
        CreateParams(Params);
      {сделаем окно способным принимать файлы}
      Params.ExStyle := Params.ExStyle or WS_EX_ACCEPTFILES;
    end;
     
    procedure TForm1.WMDropFiles(var Message: TWMDropFiles);
    var
     
      aFile: array[0..255] of Char;
      //FilesCount : Integer;
    begin
     
      inherited;
      {так можно узнать сколько файлов перетягивается}
      // FilesCount := DragQueryFile(Message.drop, $FFFFFFFF, nil, 0);
     
      begin
        {здесь можно поставить цикл открытия всех перетаскиваемых файлов
     
        for N := 0 to FilesCount - 1 do DragQueryFile(Message.drop, N, aFile, 256);
        а в данном случае открывается только первый файл в списке}
        DragQueryFile(Message.drop, 0, aFile, 256);
        Memo1.Lines.LoadFromFile(aFile);
      end;
      DragFinish(Message.Drop);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject); {Form1.OnCreate}
    begin
      {сделаем окно неравнодушным к пролетающим над ним файлам}
      DragAcceptFiles(Handle, True);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
