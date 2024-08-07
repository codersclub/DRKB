---
Title: Помещение VCL компонентов в область заголовка
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Помещение VCL компонентов в область заголовка
=============================================

Здесь есть хитрость:

Нужно разместить все необходимые элементы управления в отдельной форме,
которая должна отслеживать перемещение и изменение размеров основной
формы. Данная форма будет всегда находится над областью заголовка
основной формы.

Нижеприведенный проект включает в себя 2 формы и выпадающий список
(combobox). После запуска программы список появляется в области
заголовка главной формы. Два ключевых вопроса: 1) организация перехвата
сообщения WM\_MOVE главной формы; и 2) возвращение фокуса в главную
форму после того, как пользователь нажмет на каком-либо элементе
управления, способным иметь фокус (например, TComboBox, TButton и др.)

Я использую 32-битную Delphi 2.0 под Win95, тем не менее данный код
должен работать с любой версией Delphi.

Вот исходный код главной формы:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        procedure FormResize(Sender: TObject);
        procedure FormShow(Sender: TObject);
        procedure FormHide(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        procedure WMMove(var Msg: TWMMove); message WM_MOVE;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses Unit2;
     
    {$R *.DFM}
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      with Form2 do
      begin
        {Заменим мои магические числа реальной информацией SystemMetrics}
        Width := Form1.Width - 120;
        Top := Form1.Top + GetSystemMetrics(SM_CYFRAME);
        Left := ((Form1.Left + Form1.Width) - Width) - 60;
      end;
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    begin
      Form2.Show;
    end;
     
    procedure TForm1.FormHide(Sender: TObject);
    begin
      Form2.Hide;
    end;
     
    procedure TForm1.WMMove(var Msg: TWMMove);
    begin
      inherited;
      if (Visible) then
        FormResize(Self);
    end;
     
    end.

Вот исходный код для псевдо-заголовка. Данная форма может содержать
любые элементы управления VCL, которые вы хотите установить в области
заголовка главной формы. По существу, это - независимый диалог со
следующими свойствами:

    Caption='' {NULL строка}
    Height={высота области заголовка}
    Width={высота всех компонентов на форме}
    BorderIcons=[] {пусто}
    BorderStyle=bsNone
    FormStyle=fsStayOnTop

И, наконец, исходный код для Form2:

    unit Unit2;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm2 = class(TForm)
        ComboBox1: TComboBox;
        procedure FormCreate(Sender: TObject);
        procedure ComboBox1Change(Sender: TObject);
        procedure FormResize(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form2: TForm2;
     
    implementation
     
    uses Unit1;
     
    {$R *.DFM}
     
    procedure TForm2.FormCreate(Sender: TObject);
    begin
      Height := ComboBox1.Height - 1;
      Width := ComboBox1.Width - 1;
    end;
     
    procedure TForm2.ComboBox1Change(Sender: TObject);
    begin
      Form1.SetFocus;
    end;
     
    procedure TForm2.FormResize(Sender: TObject);
    begin
      ComboBox1.Width := Width;
    end;
     
    end.

Файл проекта (.DPR) довольно простой:

    program Project1;
     
    uses
      Forms,
      Unit1 in 'Unit1.pas' {Form1},
      Unit2 in 'Unit2.pas' {Form2};
     
    {$R *.RES}
     
    begin
      Application.Initialize;
      Application.CreateForm(TForm1, Form1);
      Application.CreateForm(TForm2, Form2);
      Application.Run;
    end.

Это все!

Хотя некоторые авторы книг утверждают:

> "Вы не можете установить компоненты Delphi в заголовок окна, точнее, не
> существует никакого способа установить их там."

Зато существует иллюзия...

