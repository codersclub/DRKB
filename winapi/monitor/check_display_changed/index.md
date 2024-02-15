---
Title: Как отследить изменения дисплея?
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как отследить изменения дисплея?
================================

::: {.date}
01.01.2007
:::

Для этого необходимо создать обработчик для перехвата сообщения
WM\_DISPLAYCHANGE. Применяется это в тех случаях, если Ваше приложение
зависит от разрешения экрана (например, приложение работает с графикой).

Далее следует пример обработчика сообщения:

    type 
    TForm1 = class(TForm) 
      Button1: TButton; 
    private 
      procedure WMDisplayChange(var Message: TMessage); message WM_DISPLAYCHANGE; 
    public 
    { Public declarations } 
    end; 
     
    var 
    Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.WMDisplayChange(var Message: TMessage); 
    begin 
      {Do Something here} 
      inherited; 
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Эта программа отслеживает изменение характеристик экрана.

    ...
    private
      procedure WMDISPLAYCHANGE(var Msg: TWMDISPLAYCHANGE);
        message WM_DISPLAYCHANGE;
    ...
    procedure TForm1.FormCreate(Sender: TObject);
    var
      bp: integer;
    begin
      bp := GetDeviceCaps(GetDC(0), BITSPIXEL);
      Form1.Caption := 'Бит на точку - ' + IntToStr(bp) +
        ' (' + FloatToStr(IntPower(2, bp)) +
        ' цветов). Разрешение ';
      Form1.Caption := Form1.Caption + 
     
        IntToStr(GetDeviceCaps(GetDC(0), HORZRES)) + 'X';
      Form1.Caption := Form1.Caption + 
        IntToStr(GetDeviceCaps(GetDC(0), VERTRES)) + ' ';
    end;
     
    procedure TForm1.WMDISPLAYCHANGE(var Msg: TWMDISPLAYCHANGE);
    var
      bp: integer;
    begin
      bp := Msg.BitsPerPixel;
      Form1.Caption := 'Бит на точку - ' + IntToStr(bp) + 
        ' (' + FloatToStr(IntPower(2, bp)) + 
        ' цветов). Разрешение ';
      Form1.Caption := Form1.Caption + IntToStr(Msg.Width) + 'X';
     
      Form1.Caption := Form1.Caption + IntToStr(Msg.Height) + ' ';
    end;

Автор: Даниил Карапетян (delphi4all@narod.ru)

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

    type
      {...} 
      private 
        procedure WMDisplayChange(var msg: TMessage);
          message WM_DISPLAYCHANGE; 
      public 
      {...} 
      end; 
    end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.WMDisplayChange(var msg: TMessage); 
    begin 
      ShowMessage('Display settings changed!'); 
      inherited; 
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
