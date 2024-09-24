---
Title: Как отобразить не главные окна своей программы в панели задач?
Date: 01.01.2007
---

Как отобразить не главные окна своей программы в панели задач?
==============================================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TMyForm.CreateParams(var Params :TCreateParams); {override;}
    begin
      inherited CreateParams(Params); {CreateWindowEx}
      Params.ExStyle := Params.ExStyle or WS_Ex_AppWindow;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    type
       TForm = class(TForm)
         {...}
       protected
         procedure CreateParams(var Params: TCreateParams); override;
       end;
     
     implementation
     
     {...}
     
     procedure TForm2.CreateParams(var Params: TCreateParams);
     begin
       inherited CreateParams(Params);
       Params.ExStyle   := Params.ExStyle or WS_EX_APPWINDOW;
       Params.WndParent := GetDesktopWindow;
     end;

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

У многооконного приложения, как Delphi, обычно только одна кнопка на
TaskBar. Если же вам понадобилось, чтобы у каждого окна была своя
кнопка, воспользуйтесь функцией SetWindowLong, добавив флаг
WS\_EX\_APPWINDOW.

В модуле первого окна:

    uses Unit2, Unit3;
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowWindow(Application.Handle, SW_HIDE);
      Form1.Hide;
      Form2.Show;
      Form3.Show;
    end;

В модуле второго окна:

    uses Unit3;
     
    {$R *.DFM}
     
    procedure TForm2.FormCreate(Sender: TObject);
    begin
      SetWindowLong(Handle, GWL_EXSTYLE,
      GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_APPWINDOW);
    end;
     
    procedure TForm2.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      if Form3.Visible = false then
        Application.Terminate;
    end;

В модуле третьего окна:

    uses Unit2;
     
    {$R *.DFM}
     
    procedure TForm3.FormCreate(Sender: TObject);
    begin
      SetWindowLong(Handle, GWL_EXSTYLE,
      GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_APPWINDOW);
    end;
     
    procedure TForm3.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      if Form2.Visible = false then
        Application.Terminate;
    end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    type
      TForm2 = class(TForm)
      private
        { Private declarations }
        procedure CreateParams(var Params: TCreateParams); override;
      end;
    ...
     
    procedure TForm2.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      with Params do
        ExStyle := ExStyle or WS_EX_APPWINDOW;
    end; 

