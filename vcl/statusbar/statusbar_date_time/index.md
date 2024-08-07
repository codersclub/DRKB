---
Title: Показ даты, времени и состояния клавиш в строке состояния
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Показ даты, времени и состояния клавиш в строке состояния
=========================================================

Предположим, у вас есть StatusBar с 4-мя панелями, плюс таймер.
Тогда вы можете сделать:

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      with StatusBar1 do
      begin
        if GetKeyState(VK_CAPITAL) <> 0 then
          panels[0].text := ' CAP'
        else
          panels[0].text := '';
        if GetKeyState(VK_NUMLOCK) <> 0 then
          panels[1].text := ' NUM'
        else
          panels[1].text := '';
        if GetKeyState(VK_SCROLL) <> 0 then
          panels[2].text := ' SCRL'
        else
          panels[2].text := '';
        panels[3].text := ' ' + DateTimeToStr(now);
      end;
    end;

О том, как можно изменить формат вывода даты, доходчиво и с примерами
изложено в электронной справке, в разделе, посвященный датам (Date).
Обратите внимание на то, что свойство Text имеет тип строки, поэтому вы
не можете написать `panels[0].text := DateTime(now)`, т.к. дата/время
имеет тип Double.

    unit Status;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, ExtCtrls, Menus, Gauges;
     
    type
     
      TStatus = class(TCustomPanel)
      private
        FDate: Boolean;
        FKeys: Boolean;
        FTime: Boolean;
        FResources: Boolean;
        DateTimePanel: TPanel;
        ResPanel: TPanel;
        ResGauge: TGauge;
        CapPanel: TPanel;
     
        NumPanel: TPanel;
        InsPanel: TPanel;
        HelpPanel: TPanel;
        UpdateWidth: Boolean;
        FTimer: TTimer;
        procedure SetDate(A: Boolean);
        procedure SetKeys(A: Boolean);
        procedure SetTime(A: Boolean);
        procedure SetResources(A: Boolean);
        procedure SetCaption(A: string);
        function GetCaption: string;
        procedure CMFontChanged(var Message: TMessage); message CM_FONTCHANGED;
     
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure SetupPanelFields(ThePanel: TPanel);
        procedure SetupPanel(ThePanel: TPanel; WidthMask: string);
        procedure UpdateStatusBar(Sender: TObject);
      published
        property ShowDate: Boolean read FDate write SetDate default True;
        property ShowKeys: Boolean read FKeys write SetKeys default True;
     
        property ShowTime: Boolean read FTime write SetTime default True;
        property ShowResources: Boolean read FResources write SetResources
          default True;
     
        property BevelInner;
        property BevelOuter;
        property BevelWidth;
        property BorderStyle;
        property BorderWidth;
        property Caption: string read GetCaption write SetCaption;
     
        property Color;
        property Ctl3D;
        property DragCursor;
        property DragMode;
        property Enabled;
        property Font;
        property ParentColor;
        property ParentCtl3d;
        property ParentFont;
        property ParentShowHint;
        property PopUpMenu;
        property ShowHint;
        property Visible;
      end;
     
    procedure Register;
    implementation
     
    procedure Register;
    begin
     
      RegisterComponents('Additional', [TStatus]);
    end;
     
    procedure TStatus.SetupPanelFields(ThePanel: TPanel);
    begin
     
      with ThePanel do
      begin
        Alignment := taCenter;
        Caption := '';
        BevelInner := bvLowered;
        BevelOuter := bvNone;
        {Установите все в True, чтобы все это отразилось на TStatus}
        ParentColor := True;
        ParentFont := True;
     
        ParentCtl3D := True;
      end;
    end;
     
    procedure TStatus.SetupPanel(ThePanel: TPanel; WidthMask: string);
    begin
     
      SetupPanelFields(ThePanel);
      with ThePanel do
      begin
        Width := Canvas.TextWidth(WidthMask);
        Align := alRight;
      end;
    end;
     
    constructor TStatus.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      Parent := TWinControl(AOwner);
     
      FTime := True;
      FDate := True;
      FKeys := True;
      FResources := True;
      {Заставляем строку состояния выровняться по нижнему краю}
      Align := alBottom;
      Height := 19;
      BevelInner := bvNone;
      BevelOuter := bvRaised;
      {Если UpdateWidth равен TRUE, StatusBar пересчитывает только ширину панелей}
      UpdateWidth := True;
      Locked := True;
      TabOrder := 0;
      ;
      TabStop := False;
      Font.Name := 'Arial';
      Font.Size := 8;
      {Создаем панель, которая будет отображать дату и время}
     
      DateTimePanel := TPanel.Create(Self);
      DateTimePanel.Parent := Self;
      SetupPanel(DateTimePanel, '  00/00/00 00:00:00 дп  ');
      {СОздаем панель, которая будет содержать графику ресурсов}
      ResPanel := TPanel.Create(Self);
      ResPanel.Parent := Self;
      SetupPanel(ResPanel, '                    ');
      {Создаем 2 Gauges, которые размещаем на Resource Panel}
      ResGauge := TGauge.Create(Self);
      ResGauge.Parent := ResPanel;
      ResGauge.Align := alClient;
     
      ResGauge.ParentFont := True;
      ResGauge.BackColor := Color;
      ResGauge.ForeColor := clLime;
      ResGauge.BorderStyle := bsNone;
      {Создаем панель, которая будет отображать состояние CapsLock}
      CapPanel := TPanel.Create(Self);
      CapPanel.Parent := Self;
      SetupPanel(CapPanel, '  Cap  ');
      {Создаем панель, которая будет отображать состояние NumLock}
      NumPanel := TPanel.Create(Self);
      NumPanel.Parent := Self;
      SetupPanel(NumPanel, '  Num  ');
     
      {Создаем панель, которая будет отображать состояние Insert/Overwrite}
      InsPanel := TPanel.Create(Self);
      InsPanel.Parent := Self;
      SetupPanel(InsPanel, '  Ins  ');
      {Создаем панель, которая будет отображать текст состояния}
      HelpPanel := TPanel.Create(Self);
      HelpPanel.Parent := Self;
      SetupPanelFields(HelpPanel);
      {Имеем вспомогательную панель, занимающую все остальное пространство}
      HelpPanel.Align := alClient;
      HelpPanel.Alignment := taLeftJustify;
     
      {Это таймер, который регулярно обновляет строку состояния}
      FTimer := TTimer.Create(Self);
      if FTimer <> nil then
      begin
        FTimer.OnTimer := UpdateStatusBar;
        {Обновление происходит дважды в секунду}
        FTimer.Interval := 500;
        FTimer.Enabled := True;
      end;
    end;
     
    destructor TStatus.Destroy;
    begin
     
      FTimer.Free;
      HelpPanel.Free;
     
      InsPanel.Free;
      NumPanel.Free;
      CapPanel.Free;
      ResGauge.Free;
      ResPanel.Free;
      DateTimePanel.Free;
      inherited Destroy;
    end;
     
    procedure TStatus.SetDate(A: Boolean);
    begin
     
      FDate := A;
      UpdateWidth := True;
    end;
     
    procedure TStatus.SetKeys(A: Boolean);
    begin
     
      FKeys := A;
      UpdateWidth := True;
    end;
     
    procedure TStatus.SetTime(A: Boolean);
    begin
     
      FTime := A;
      UpdateWidth := True;
    end;
     
    procedure TStatus.SetResources(A: Boolean);
    begin
     
      FResources := A;
      UpdateWidth := True;
    end;
     
    {Если мы получаем или устанавливаем заголовок TStatus, то вместо этого задаем
    заголовок HelpPanel}
     
    procedure TStatus.SetCaption(A: string);
    begin
     
      HelpPanel.Caption := ' ' + A;
    end;
     
    function TStatus.GetCaption: string;
    begin
     
      GetCaption := HelpPanel.Caption;
    end;
     
    {Данная процедура устанавливает соответствующие заголовки}
     
    procedure TStatus.UpdateStatusBar(Sender: TObject);
    begin
     
      if ShowDate and ShowTime then
        DateTimePanel.Caption := DateTimeToStr(Now)
      else if ShowDate and not ShowTime then
        DateTimePanel.Caption := DateToStr(Date)
      else if not ShowDate and ShowTime then
     
        DateTimePanel.Caption := TimeToStr(Time)
      else
        DateTimePanel.Caption := '';
      if UpdateWidth then
        with DateTimePanel do
          if ShowDate or ShowTime then
            Width := Canvas.TextWidth(' ' + Caption + ' ')
          else
            Width := 0;
      if ShowResources then
      begin
        ResGauge.Progress := GetFreeSystemResources(GFSR_SYSTEMRESOURCES);
     
        if ResGauge.Progress < 20 then
          ResGauge.ForeColor := clRed
        else
          ResGauge.ForeColor := clLime;
      end;
      if UpdateWidth then
        if ShowResources then
          ResPanel.Width := Canvas.TextWidth('                    ')
        else
          ResPanel.Width := 0;
      if ShowKeys then
      begin
        if (GetKeyState(vk_NumLock) and $01) <> 0 then
     
          NumPanel.Caption := '  Num  '
        else
          NumPanel.Caption := '';
        if (GetKeyState(vk_Capital) and $01) <> 0 then
          CapPanel.Caption := '  Cap  '
        else
          CapPanel.Caption := '';
        if (GetKeyState(vk_Insert) and $01) <> 0 then
          InsPanel.Caption := '  Ins  '
        else
          InsPanel.Caption := '';
      end;
      if UpdateWidth then
        if ShowKeys then
     
        begin
          NumPanel.Width := Canvas.TextWidth(' Num ');
          InsPanel.Width := Canvas.TextWidth(' Ins ');
          CapPanel.Width := Canvas.TextWidth(' Cap ');
        end
        else
        begin
          NumPanel.Width := 0;
          InsPanel.Width := 0;
          CapPanel.Width := 0;
        end;
      UpdateWidth := False;
    end;
     
    {Позволяем изменять шрифты, используемые панелями для вывода текста}
     
    procedure TStatus.CMFontChanged(var Message: TMessage);
    begin
     
      inherited;
      UpdateWidth := True;
    end;
     
    end.
     
    interface
     
    implementation
     
    end.

