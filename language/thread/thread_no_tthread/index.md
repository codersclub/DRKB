---
Title: Как создавать потоки без класса TThread?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как создавать потоки без класса TThread?
========================================

Ниже приведены два примера, которые при создании потоков позволяют
обойтись без класса TThread, используя API функции CreateThread,
SuspendThread, ResumeThread и TerminateThread.

**Пример 1:**

Поместите на форму 2 окошка редактирования (edit) и 6 кнопок. Далее
приведён сам код:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    procedure incedit1; stdcall;
    procedure incedit2; stdcall;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Edit1: TEdit;
        Edit2: TEdit;
        Button6: TButton;
        Button7: TButton;
        Button2: TButton;
        Button3: TButton;
        Button5: TButton;
        Button4: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button6Click(Sender: TObject);
        procedure Button7Click(Sender: TObject);
        procedure Button4Click(Sender: TObject);
        procedure Button5Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    var
      th1, th2: cardinal;
      h1, h2: integer;
     
    procedure incedit1;
    var
      i: integer;
    begin
      i := 0;
      while true do
      begin
        form1.edit1.text := inttostr(i);
        i := i + 1;
      end;
    end;
     
    procedure incedit2;
    var
      i: integer;
    begin
      i := 0;
      while true do
      begin
        form1.edit2.text := inttostr(i);
        i := i + 1;
      end;
    end;
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      h1 := beginthread(nil, 1024, @incedit1, nil, 0, th1);
      h2 := beginthread(nil, 1024, @incedit2, nil, 0, th2);
    end;
     
    procedure TForm1.Button6Click(Sender: TObject);
    begin
      terminatethread(h1, 0);
    end;
     
    procedure TForm1.Button7Click(Sender: TObject);
    begin
      terminatethread(h2, 0);
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      resumethread(h1);
    end;
     
    procedure TForm1.Button5Click(Sender: TObject);
    begin
      resumethread(h2);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      suspendthread(h1);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      suspendthread(h2);
    end;
     
    end.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    procedure printh(p: pointer); stdcall;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure printh(p: pointer); stdcall;
    begin
      TForm1(p).caption := 'Hello from thread';
      ExitThread(0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      h1: cardinal;
    begin
      createthread(nil, 128, @printh, self, 0, h1);
    end;
     
    end.


**Примечание от Jin X:**

Программа не работает. Запускаю, жму Button1, счётчик покрутится
полсекунды и всё. Кстати, у `procedure incedit1; stdcall;` не должно быть
параметра типа pointer? Но даже и с ним не пашет. А вот если после
`i := i + 1;` поставить `Sleep(10)`, то будет работать.
Вот только непонятно почему. Может, из-за того, что нет синхронизации?
