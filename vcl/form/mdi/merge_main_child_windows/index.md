---
Title: Как сделать MDI-приложение, где сливаются меню дочернего и главного окна и полосы инструментов?
Date: 01.01.2007
---


Как сделать MDI-приложение, где сливаются меню дочернего и главного окна и полосы инструментов?
===============================================================================================

Вариант 1:

CoolBar.

    procedure TMainForm.SetBands(AControls: array of TWinControl;
    ABreaks: array of boolean);
    var
      i: integer;
    begin
      with CoolBar do
      begin
        for i:=0 to High(AControls) do
        begin
          if Bands.Count=succ(i) then
            TCoolBand.Create(Bands);
          with Bands[succ(i)] do
          begin
            if Assigned(Control) then
              Control.Hide;
            MinHeight:=AControls[i].Height;
            Break:=ABreaks[i];
            Control:=AControls[i];
            Control.Show;
            Visible:=true;
          end
        end;
        for i:=High(AControls)+2 to pred(Bands.Count) do
          Bands[i].Free
      end
    end;

и

    procedure TMsgForm.FormActivate(Sender: TObject);
    begin
      MainForm.SetBands([ToolBar],[false])
    end;

**Пpимечание:**

Оба массива pавны по длине. `CoolBar.Bands[0]` должен существовать
всегда,.. на нём я pазмешаю "глобальные" кнопки. `СoolBar[1]` тоже
можно сделать в DesignTime с `Break:=false` и пpидвинуть поближе с началу.
Пpи `CoolBar.AutoSize:=true` возможно "мигание" (пpи добавлении на новую
стpоку), так что можно добавить:

    AutoSize := false;
    try
      ...
    finally
    AutoSize := true;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    TMainForm
      ...
      object SpeedBar: TPanel
      ...
      Align = alTop
      BevelOuter = bvNone
      object ToolBar: TPanel
      ...
      Align = alLeft
      BevelOuter = bvNone
      end
      object RxSplitter1: TRxSplitter
      ...
      ControlFirst = ToolBar
      ControlSecond = ChildBar
      Align = alLeft
      BevelOuter = bvLowered
      end
      object ChildBar: TPanel
      ...
      Align = alClient
      BevelOuter = bvNone
      end
    end
     
    TMdiChild {пpородитель всех остальных}
      ...
      object pnToolBar: TPanel
      ...
      Align = alTop
      BevelOuter = bvNone
      Visible = False
    end
     
    procedure TMDIForm.FormActivate(Sender: TObject);
    begin
      pnToolBar.Parent := MainForm.ChildBar;
      pnToolBar.Visible := True;
    end;
     
    procedure TMDIForm.FormDeactivate(Sender: TObject);
    begin
      pnToolBar.Visible := false;
      pnToolBar.Parent := self
    end;

