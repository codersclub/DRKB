---
Title: Автоматически нажимающаяся кнопка
Date: 01.01.2007
---


Автоматически нажимающаяся кнопка
=================================

::: {.date}
01.01.2007
:::

Этот компонент представляет из себя кнопку, на которую не надо нажимать,
чтобы получить событие OnClick. Достаточно переместить курсор мышки на
кнопку. При создании такого компонента традиционным способом, требуется
довольно много времени, так как необходимо обрабатывать мышку,
перехватывать её и т.д. Однако результат стоит того!

Предлагаю взглянуть на две версии данного компонента. В более простой
версии обработчик перемещения мышки просто перехватывает сообщения
Windows с нужным кодом и вызывает обработчик события OnClick:

    type
      TAutoButton1 = class(TButton)
      private
        procedure WmMouseMove (var Msg: TMessage);
          message wm_MouseMove;
      end;
     
    procedure TAutoButton1.WmMouseMove (var Msg: TMessage);
    begin
      inherited;
      if Assigned (OnClick) then
        OnClick (self);
    end;

Вторая версии имеет больше исходного кода, так как в ней я просто
пытаюсь повторить событие мышки OnClick когда пользователь перемещает
мышку над кнопкой либо по истечении определённого времени. Далее следует
объявление класса:

    type
      TAutoKind = (akTime, akMovement, akBoth);
     
      TAutoButton2 = class(TButton)
      private
        FAutoKind: TAutoKind;
        FMovements: Integer;
        FSeconds: Integer;
        // really private
        CurrMov: Integer;
        Capture: Boolean;
        MyTimer: TTimer;
        procedure EndCapture;
        // обработчики сообщений
        procedure WmMouseMove (var Msg: TWMMouse);
          message wm_MouseMove;
        procedure TimerProc (Sender: TObject);
        procedure WmLBUttonDown (var Msg: TMessage);
          message wm_LBUttonDown;
        procedure WmLButtonUp (var Msg: TMessage);
          message wm_LButtonUp;
      public
        constructor Create (AOwner: TComponent); override;
      published
        property AutoKind: TAutoKind
          read FAutoKind write FAutoKind default akTime;
        property Movements: Integer
          read FMovements write FMovements default 5;
        property Seconds: Integer
          read FSeconds write FSeconds default 10;
      end;

Итак, когда курсор мышки попадает в область кнопки (WmMouseMove), то
компонент запускает таймер либо счётчик количества сообщений о
перемещении. По истечении определённого времени либо при получении
нужного количества сообщений о перемещении, компонент эмулирует событие
нажатия кнопкой.

    procedure TAutoButton2.WmMouseMove (var Msg: TWMMouse);
    begin
      inherited;
      if not Capture then
      begin
        SetCapture (Handle);
        Capture := True;
        CurrMov := 0;
        if FAutoKind <> akMovement then
        begin
          MyTimer := TTimer.Create (Parent);
          if FSeconds <> 0 then
            MyTimer.Interval := 3000
          else
            MyTimer.Interval := FSeconds * 1000;
          MyTimer.OnTimer := TimerProc;
          MyTimer.Enabled := True;
        end;
      end
      else // захватываем
      begin
        if (Msg.XPos > 0) and (Msg.XPos < Width)
          and (Msg.YPos > 0) and (Msg.YPos < Height) then
        begin
          // если мы подсчитываем кол-во движений...
          if FAutoKind <> akTime then
          begin
            Inc (CurrMov);
            if CurrMov >= FMovements then
            begin
              if Assigned (OnClick) then
                OnClick (self);
              EndCapture;
            end;
          end;
        end
        else // за пределами... стоп!
          EndCapture;
      end;
    end;
     
    procedure TAutoButton2.EndCapture;
    begin
      Capture := False;
      ReleaseCapture;
      if Assigned (MyTimer) then
      begin
        MyTimer.Enabled := False;
        MyTimer.Free;
        MyTimer := nil;
      end;
    end;
     
    procedure TAutoButton2.TimerProc (Sender: TObject);
    begin
      if Assigned (OnClick) then
        OnClick (self);
      EndCapture;
    end;
     
    procedure TAutoButton2.WmLBUttonDown (var Msg: TMessage);
    begin
      if not Capture then
        inherited;
    end;
     
    procedure TAutoButton2.WmLButtonUp (var Msg: TMessage);
    begin
      if not Capture then
        inherited;
    end;

Взято из <https://forum.sources.ru>
