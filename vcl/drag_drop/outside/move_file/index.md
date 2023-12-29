---
Title: Как перетаскивать файлы?
Date: 01.01.2007
---


Как перетаскивать файлы?
========================

::: {.date}
01.01.2007
:::

как принимать "перетаскиваемые" файлы.

При получении программой файлов, окну посылается сообщение
WM\_DROPFILES.

При помощи функции DragQueryFile можно определить количество и имена
файлов.

При помощи функции DragQueryPoint можно определить координату мыши в тот
момент,

когда пользователь "отпустил" файлы.

Эта программа открывает все "перетащенные" в нее файлы.

Причем, если пользователь перетащил файлы в PageControl1, то в
PageControl1 эти файлы и откроются.

    ...
      public
        procedure WMDropFiles(var Msg: TWMDropFiles);
          message WM_DROPFILES;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses ShellAPI, stdctrls;
     
    procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);
    var
      HF: THandle;
      s: array [0..1023] of char;
      i, FileCount: integer;
      p: TPoint;
      ts: TTabSheet;
      memo: TMemo;
    begin
      HF := Msg.Drop;
      FileCount := DragQueryFile(HF, $FFFFFFFF, nil, 0);
      for i := 0 to FileCount - 1 do begin
        DragQueryFile(HF, i, s, sizeof(s));
        ts := TTabSheet.Create(nil);
        DragQueryPoint(HF, p);
        if PtInRect(PageControl1.BoundsRect, p)
          then ts.PageControl := PageControl1
          else ts.PageControl := PageControl2;
        ts.Caption := ExtractFileName(s);
        memo := TMemo.Create(nil);
        memo.Parent := ts;
        memo.Align := alClient;
        memo.Lines.LoadFromFile(s);
      end;
      DragFinish(HF);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      PageControl1.Align := alLeft;
      PageControl2.Align := alClient;
      DragAcceptFiles(Form1.Handle, true);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      DragAcceptFiles(Form1.Handle, false);
    end;

Даниил Карапетян.

На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.

Email: <delphi4all@narod.ru>

------------------------------------------------------------------------

    { На эту форму можно бросить файл (например из проводника) 
      и он будет открыт }
    unit Unit1;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, 
      Controls, Forms, Dialogs,StdCtrls, 
      ShellAPI {обязательно!};
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        FileNameLabel: TLabel;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      protected
       {Это и есть самая главная процедура}
        procedure WMDropFiles(var Msg: TMessage); message wm_DropFiles; 
    end;
     
    var
      Form1: TForm1;
    implementation
    {$R *.DFM}
     
    procedure TForm1.WMDropFiles(var Msg: TMessage);
    var 
       Filename: array[0 .. 256] of Char;
       Count   : integer;
    begin
      { Получаем количество файлов (просто пример) }
       nCount := DragQueryFile( msg.WParam, $FFFFFFFF, 
         acFileName, cnMaxFileNameLen);
      { Получаем имя первого файла }
      DragQueryFile( THandle(Msg.WParam),
         0, { это номер файла }
         Filename,SizeOf(Filename) ) ;
      { Открываем его }
      with FileNameLabel do begin
       Caption := LowerCase(StrPas(FileName));
       Memo1.Lines.LoadfromFile(Caption);
      end;
      { Отдаем сообщение о завершении процесса }
      DragFinish(THandle(Msg.WParam));
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     { Говорим Windows, что на нас можно бросать файлы }
     DragAcceptFiles(Handle, True); 
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     { Закрываем за собой дверь золотым ключиком}
     DragAcceptFiles(Handle, False); 
    end;
    end.

Источник: <https://dmitry9.nm.ru/info/>

------------------------------------------------------------------------

Большинство программ, предназначенных для работы с текстом,
предоставляют пользователю возможность перетаскивать файлы в свою
программу, а мы что лысые... :-)) ...щас тоже организуем:

Подключаем модуль ShellAPI в области uses

По созданию окна \[событие OnCreate\] пишем такой код:

    DragAcceptFiles(Handle, true);

Когда вы перетаскиваете файл на своё приложение и отпускаете кнопку
мыши, Windows посылает этому окну сообщение wm\_DropFiles. Сообщение
сопровождается именем файла. Обработчик этого сообщения нужно включить в
раздел protected класса формы. Вставьте следующий код:

    protected
      procedure WMDropFiles (var Msg: TMessage); message wm_DropFiles;

Далее обрабатываем сообщение:

    procedure TForm1.WMDropFiles(var Msg: TMessage);
    var
      FileName: array[0..256] of char;
    begin
      DragQueryFile(THandle(Msg.WParam), 0, FileName, SizeOf(Filename));
      Memo1.Lines.LoadFromFile(FileName);
      DragFinish(THandle(Msg.WParam));
    end;

или так:

    procedure TForm1.WMDROPFILES(var Msg: TMessage);
    var
      i, amount, size: integer;
      Filename: PChar;
    begin
      inherited;
      Amount := DragQueryFile(Msg.WParam, $FFFFFFFF, Filename, 255);
      for i := 0 to (Amount - 1) do
      begin
        size := DragQueryFile(Msg.WParam, i, nil, 0) + 1;
        Filename := StrAlloc(size);
        DragQueryFile(Msg.WParam, i, Filename, size);
        listbox1.items.add(StrPas(Filename));
        StrDispose(Filename);
      end;
      DragFinish(Msg.WParam);
    end;
     
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
