---
Title: Как рисовать на экране
Date: 01.01.2007
---


Как рисовать на экране
======================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Обладая такими способностями, вы сможете, например, разлиновать
поверхность экрана как в тетради в клеточку, выводить пугающие
пользователя надписи и даже создать эффект окаменение экрана, если,
конечно, разработаете алгоритм выполнения данной задачи.

Я покажу как рисовать на экране на примере разлиновки:

Сначала объявите глобальную переменную

    Scr: TCanvas;

Затем по событию OnCreate() для формы напишите такой код:

    Scr := TCanvas.Create;
    Scr.Handle := GetDC(HWND_DESKTOP);


По событию OnDestroy() такой:

    Scr.Free;

Обработчик события по нажатию на кнопку пусть выглядит так:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      i: integer;
    begin
      i := 0;
      while i < 1024 do
      begin
        with Scr do
        begin
          MoveTo(i, 0);
          LineTo(i, 768);
          i := i + 10;
        end;
      end;
      i := 0;
      while i < 768 do
      begin
        with Scr do
        begin
          MoveTo(0, i);
          LineTo(1024, i);
          i := i + 10;
        end;
      end;
      Button1.Refresh;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

Для этого надо воспользоваться функциями API. Получить контекст чужого
окна, либо всего экрана:

    function GetDC(Wnd: HWnd): HDC;

где Wnd - указатель на нужное окно, или 0 для получения контекста всего
экрана. И далее, пользуясь функциями API, нарисовать все что надо.

    procedure DrawOnScreen;
    var
      ScreenDC: hDC;
    begin
      ScreenDC := GetDC(0); {получить контекст экрана}
      Ellipse(ScreenDC, 0, 0, 200, 200); {нарисовать}
      ReleaseDC(0, ScreenDC); {освободить контекст}
    end;

Не забывайте после своих манипуляций посылать пострадавшим (или всем)
окнам сообщение о необходимости перерисовки, для восстановления их
первоначального вида.

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // Пример рисует две горизонтальные линии на экране используя TDesktopCanvas.
    program TrinitronTraining;
     
    uses
      Messages, Windows, Graphics, Forms;
     
    type
      TDesktopCanvas = class(TCanvas)
      private
        DC : hDC;
        function GetWidth:Integer;
        function GetHeight:Integer;
      public
        constructor Create;
        destructor Destroy; override;
      published
        property Width: Integer read GetWidth;
        property Height: Integer read GetHeight;
    end;
     
    { Объект TDesktopCanvas }
    function TDesktopCanvas.GetWidth:Integer;
    begin
      Result:=GetDeviceCaps(Handle,HORZRES);
    end;
     
    function TDesktopCanvas.GetHeight:Integer;
    begin
      Result:=GetDeviceCaps(Handle,VERTRES);
    end;
     
    constructor TDesktopCanvas.Create;
    begin
      inherited Create;
      DC := GetDC(0);
      Handle := DC;
    end;
     
    destructor TDesktopCanvas.Destroy;
    begin
      Handle := 0;
      ReleaseDC(0, DC);
      inherited Destroy;
    end;
     
     
    const
      YCount = 2;
     
    var
      desktop : TDesktopCanvas;
      dx,dy : Integer;
      i : Integer;
      F : array[1..YCount] of TForm;
     
    function CreateLine(Y : Integer) : TForm;
    begin
      Result := TForm.Create(Application);
      with Result do begin
        Left := 0;
        Top := y;
        Width := dx;
        Height := 1;
        BorderStyle := bsNone;
        FormStyle := fsStayOnTop;
        Visible := True;
      end;
    end;
     
    procedure ProcessMessage;
    var
      Msg : TMsg;
    begin
      if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then
        if Msg.message = WM_QUIT then
          Application.Terminate;
    end;
     
    begin
      desktop := TDesktopCanvas.Create;
      try
        dx := desktop.Width;
        dy := desktop.Height div (YCount+1);
      finally
        desktop.free;
      end;
      for i:=1 to YCount do
        F[i]:=CreateLine(i*dy);
      Application.NormalizeTopMosts;
      ShowWindow(Application.Handle, SW_Hide);
     
      for i:=1 to YCount do
        SetWindowPos(F[i].Handle, HWND_TOPMOST, 0,0,0,0, SWP_NOACTIVATE+SWP_NOMOVE+SWP_NOSIZE);
     
      {
      //следующие строки используются для того, чтобы не останавливаться
      repeat
        ProcessMessage;
      until false;
      }
      Sleep(15000);
     
      for i:=1 to YCount do
        F[i].Free;
    end.


