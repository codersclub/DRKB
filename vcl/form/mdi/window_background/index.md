---
Title: Фон MDI-окон
Date: 01.01.2007
---


Фон MDI-окон
============

Вариант 1:

Author: Neil Rubenkind

Привожу код, который может оказаться полезным. Он позволяет в обычной
или MDI-форме создать графический tile-фон или градиентную заливку.

(Tile - "секция, плитка" - непрерывное заполнение определенной области
немасштабируемым изображением слева-направо сверху вниз - В.О.)

Самая сложная часть кода осуществляет обработку системного сообщения,
адресуемого дескриптору окна (ClientHandle), осуществляющему управление
дочерними формами. Происходит это в момент вывода изображений в
MDI-форме. Все что вам необходимо сделать - в режиме проектирования
загрузить в imgTile необходимые изображения и перенести в свою программу
следующий код:

    unit UMain;
     
    interface
     
    uses
      Windows, Messages, Classes, SysUtils, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, Menus;
     
    type
      TfrmMain = class(TForm)
        mnuMain: TMainMenu;
        mnuFile: TMenuItem;
        mnuExit: TMenuItem;
        imgTile: TImage;
        mnuOptions: TMenuItem;
        mnuBitmap: TMenuItem;
        mnuGradient: TMenuItem;
        procedure mnuExitClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure mnuBitmapClick(Sender: TObject);
        procedure mnuGradientClick(Sender: TObject);
        procedure FormCloseQuery(Sender: TObject; var CanClose: Boolean);
        procedure FormResize(Sender: TObject);
        procedure FormPaint(Sender: TObject);
      private
        { Private declarations }
        MDIDefProc: pointer;
        MDIInstance: TFarProc;
        procedure MDIWndProc(var prmMsg: TMessage);
        procedure CreateWnd; override;
        procedure ShowBitmap(prmDC: hDC);
        procedure ShowGradient(prmDC: hDC; prmRed, prmGreen, prmBlue: byte);
      public
        { Public declarations }
      end;
     
    var
     
      frmMain: TfrmMain;
      glbImgWidth: integer;
      glbImgHeight: integer;
     
    implementation
     
    {$R *.DFM}
     
    procedure TfrmMain.FormCreate(Sender: TObject);
    begin
     
      glbImgHeight := imgTile.Picture.Height;
      glbImgWidth := imgTile.Picture.Width;
    end;
     
    procedure TfrmMain.FormResize(Sender: TObject);
    begin
     
      FormPaint(Sender);
    end;
     
    procedure TfrmMain.MDIWndProc(var prmMsg: TMessage);
    begin
     
      with prmMsg do
      begin
        if Msg = WM_ERASEBKGND then
        begin
          if mnuBitmap.Checked then
            ShowBitmap(wParam)
          else
            ShowGradient(wParam, 255, 0, 0);
          Result := 1;
        end
        else
          Result := CallWindowProc(MDIDefProc, ClientHandle, Msg, wParam, lParam);
      end;
    end;
     
    procedure TfrmMain.CreateWnd;
    begin
     
      inherited CreateWnd;
      MDIInstance := MakeObjectInstance(MDIWndProc); { создаем ObjectInstance }
      MDIDefProc := pointer(SetWindowLong(ClientHandle, GWL_WNDPROC,
        longint(MDIInstance)));
    end;
     
    procedure TfrmMain.FormCloseQuery(Sender: TObject; var CanClose:
      Boolean);
    begin
     
      { восстанавоиваем proc окна по умолчанию }
      SetWindowLong(ClientHandle, GWL_WNDPROC, longint(MDIDefProc));
      { избавляемся от ObjectInstance }
      FreeObjectInstance(MDIInstance);
    end;
     
    procedure TfrmMain.mnuExitClick(Sender: TObject);
    begin
     
      close;
    end;
     
    procedure TfrmMain.mnuBitmapClick(Sender: TObject);
     
    var
      wrkDC: hDC;
    begin
     
      wrkDC := GetDC(ClientHandle);
      ShowBitmap(wrkDC);
      ReleaseDC(ClientHandle, wrkDC);
      mnuBitmap.Checked := true;
      mnuGradient.Checked := false;
    end;
     
    procedure TfrmMain.mnuGradientClick(Sender: TObject);
    var
      wrkDC: hDC;
    begin
      wrkDC := GetDC(ClientHandle);
      ShowGradient(wrkDC, 0, 0, 255);
      ReleaseDC(ClientHandle, wrkDC);
      mnuGradient.Checked := true;
      mnuBitMap.Checked := false;
    end;
     
    procedure TfrmMain.ShowBitmap(prmDC: hDC);
    var
      wrkSource: TRect;
      wrkTarget: TRect;
      wrkX: integer;
      wrkY: integer;
    begin
      { заполняем (tile) окно изображением }
      if FormStyle = fsNormal then
      begin
        wrkY := 0;
        while wrkY < ClientHeight do { заполняем сверху вниз.. }
        begin
          wrkX := 0;
          while wrkX < ClientWidth do { ..и слева направо. }
          begin
            Canvas.Draw(wrkX, wrkY, imgTile.Picture.Bitmap);
            Inc(wrkX, glbImgWidth);
          end;
          Inc(wrkY, glbImgHeight);
        end;
      end
      else if FormStyle = fsMDIForm then
      begin
        Windows.GetClientRect(ClientHandle, wrkTarget);
        wrkY := 0;
        while wrkY < wrkTarget.Bottom do
        begin
          wrkX := 0;
          while wrkX < wrkTarget.Right do
          begin
            BitBlt(longint(prmDC), wrkX, wrkY, imgTile.Width, imgTile.Height,
              imgTile.Canvas.Handle, 0, 0, SRCCOPY);
            Inc(wrkX, glbImgWidth);
          end;
          Inc(wrkY, glbImgHeight);
        end;
      end;
    end;
     
    procedure TfrmMain.ShowGradient(prmDC: hDC; prmRed, prmGreen, prmBlue: byte);
    var
      wrkBrushNew: hBrush;
      wrkBrushOld: hBrush;
      wrkColor: TColor;
      wrkCount: integer;
      wrkDelta: integer;
      wrkRect: TRect;
      wrkSize: integer;
      wrkY: integer;
    begin
      { процедура заполнения градиентной заливкой }
      wrkDelta := 255 div (1 + ClientHeight); { желаемое количество оттенков }
      if wrkDelta = 0 then
        wrkDelta := 1; { да, обычно 1 }
      wrkSize := ClientHeight div 240; { размер смешанных баров }
      if wrkSize = 0 then
        wrkSize := 1;
      for wrkY := 0 to 1 + (ClientHeight div wrkSize) do
      begin
        wrkColor := RGB(prmRed, prmGreen, prmBlue);
        wrkRect := Rect(0, wrkY * wrkSize, ClientWidth, (wrkY + 1) * wrkSize);
        if FormStyle = fsNormal then
        begin
          Canvas.Brush.Color := wrkColor;
          Canvas.FillRect(wrkRect);
        end
        else if FormStyle = fsMDIForm then
        begin
          wrkBrushNew := CreateSolidBrush(wrkColor);
          wrkBrushOld := SelectObject(prmDC, wrkBrushNew);
          FillRect(prmDC, wrkRect, wrkBrushNew);
          SelectObject(prmDC, wrkBrushOld);
          DeleteObject(wrkBrushNew);
        end;
        if prmRed > wrkDelta then
          Dec(prmRed, wrkDelta);
        if prmGreen > wrkDelta then
          Dec(prmGreen, wrkDelta);
        if prmBlue > wrkDelta then
          Dec(prmBlue, wrkDelta);
      end;
    end;
     
    procedure TfrmMain.FormPaint(Sender: TObject);
    begin
      if FormStyle = fsNormal then
        if mnuBitMap.Checked then
          mnuBitMapClick(Sender)
        else
          mnuGradientClick(Sender);
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

Сначала установите свойство формы FormStyle в fsMDIForm. Затем
разместите Image на форме и загрузите в него картинку. Найдите { Private
Declarations } в обьявлении формы и добаьте следующие строки:

    FClientInstance: TFarProc;
    FPrevClientProc: TFarProc;
    procedure ClientWndProc(var message: TMessage);

Добавьте следующие строки в разделе implementation:

    procedure TMainForm.ClientWndProc(var message: TMessage);
    var
      Dc: hDC;
      Row: Integer;
      Col: Integer;
    begin
      with message do
        case Msg of
          WM_ERASEBKGND:
          begin
            Dc := TWMEraseBkGnd(message).Dc;
            for Row := 0 to ClientHeight div Image1.Picture.Height do
              for Col := 0 to ClientWidth div Image1.Picture.Width do
                BitBlt(Dc, Col * Image1.Picture.Width, Row *
                Image1.Picture.Height, Image1.Picture.Width,
                Image1.Picture.Height, Image1.Picture.Bitmap.Canvas.Handle,
                0, 0, SRCCOPY);
            Result := 1;
          end;
          else
            Result := CallWindowProc(FPrevClientProc,
            ClientHandle, Msg, wParam, lParam);
        end;
    end;

По созданию окна [событие OnCreate()] напишите такой код:

    FClientInstance := MakeObjectInstance(ClientWndProc);
    FPrevClientProc := Pointer(GetWindowLong(ClientHandle, GWL_WNDPROC));
    SetWindowLong(ClientHandle, GWL_WNDPROC, LongInt(FClientInstance));

Добавьте к проекту новую форму и установите ее свойство FormStyle в
fsMDIChild


------------------------------------------------------------------------

Вариант 3:

Source: <https://delphiworld.narod.ru>

    procedure TForm.OnPaint(Sender: TObject);
     
      procedure Tile(c: TCanvas; b: TBitMap);
      var
        x, y, h, w, i, j: integer;
      begin
        with b do
        begin
          h := b.height;
          w := b.width;
        end;
        y := 0;
        with c.Cliprect do
        begin
          i := bottom - top - 1; //высота
          j := right - left - 1; //ширина
        end;
        while y < i do
        begin
          x := 0;
          while x < j do
          begin
            c.draw(x, y, b);
            inc(x, w);
          end;
          inc(y, h);
        end;
      end;
     
    begin
      if Sender is TForm then
        Tile(TForm(Sender).Canvas, fTileWith);
    end;


------------------------------------------------------------------------

Вариант 4:

Author: Neil Rubenkind

Source: <https://delphiworld.narod.ru>

Несколько людей уже спрашивали, как залить фон главной MDI-формы
повторяющимся изображением. Ключевым моментом здесь является работа с
дескриптором окна MDI-клиента (свойство ClientHandle) и заполнение
изображением окно клиента в ответ на сообщение WM\_ERASEBKGND. Тем не
менее здесь существует пара проблем: прокрутка главного окна и
перемещение дочернего MDI-окна за пределы экрана портят фон, и
закрашивание за иконками дочерних окон не происходит.

Ну наконец-то! Похоже я нашел как решить обе проблемы. Вот код для тех,
кому все это интересно. Я начинаю с проблемы дочерних форм, ниже код для
решения проблемы с главной формой (модули с именами MDIWAL2U.PAS и
MDIWAL1U.PAS). На главной форме расположен компонент TImage с именем
Image1, содержащий изображение для заливки фона.

    ...
    private
    { Private declarations }
     
    procedure WMIconEraseBkgnd(var Message: TWMIconEraseBkgnd);
      message WM_ICONERASEBKGND;
    ...
     
    USES MdiWal1u;
     
    procedure TForm2.WMIconEraseBkgnd(var Message: TWMIconEraseBkgnd);
    begin
      TForm1(Application.Mainform).PaintUnderIcon(Self, Message.DC);
      Message.Result := 0;
    end;
     
    ...
    { Private declarations }
    bmW, bmH: Integer;
    FClientInstance,
    FPrevClientProc: TFarProc;
     
    procedure ClientWndProc(var Message: TMessage);
    public
        procedure PaintUnderIcon(F: TForm; D: hDC);
        ...
          procedure TForm1.PaintUnderIcon(F: TForm; D: hDC);
        var
     
          DestR, WndR: TRect;
          Ro, Co,
            xOfs, yOfs,
            xNum, yNum: Integer;
        begin
     
          {вычисляем необходимое число изображений для заливки D}
          GetClipBox(D, DestR);
          with DestR do
          begin
            xNum := Succ((Right - Left) div bmW);
            yNum := Succ((Bottom - Top) div bmW);
          end;
          {вычисление смещения изображения в D}
          GetWindowRect(F.Handle, WndR);
          with ScreenToClient(WndR.TopLeft) do
          begin
            xOfs := X mod bmW;
            yOfs := Y mod bmH;
          end;
          for Ro := 0 to xNum do
            for Co := 0 to yNum do
              BitBlt(D, Co * bmW - xOfs, Ro * bmH - Yofs, bmW, bmH,
                Image1.Picture.Bitmap.Canvas.Handle,
                0, 0, SRCCOPY);
        end;
     
        procedure TForm1.ClientWndProc(var Message: TMessage);
        var
          Ro, Co: Word;
        begin
     
          with Message do
            case Msg of
              WM_ERASEBKGND:
                begin
                  for Ro := 0 to ClientHeight div bmH do
                    for Co := 0 to ClientWIDTH div bmW do
                      BitBlt(TWMEraseBkGnd(Message).DC,
                        Co * bmW, Ro * bmH, bmW, bmH,
                        Image1.Picture.Bitmap.Canvas.Handle,
                        0, 0, SRCCOPY);
                  Result := 1;
                end;
              WM_VSCROLL,
                WM_HSCROLL:
                begin
                  Result := CallWindowProc(FPrevClientProc,
                    ClientHandle, Msg, wParam, lParam);
                  InvalidateRect(ClientHandle, nil, True);
                end;
            else
              Result := CallWindowProc(FPrevClientProc,
                ClientHandle, Msg, wParam, lParam);
            end;
        end;
     
        procedure TForm1.FormCreate(Sender: TObject);
        begin
     
          bmW := Image1.Picture.Width;
          bmH := Image1.Picture.Height;
          FClientInstance := MakeObjectInstance(ClientWndProc);
          FPrevClientProc := Pointer(
            GetWindowLong(ClientHandle, GWL_WNDPROC));
          SetWindowLong(ClientHandle, GWL_WNDPROC,
            LongInt(FClientInstance));
        end;


------------------------------------------------------------------------

Вариант 5:

Author: [Alexander N.Voronin](mailto:van@ttk.jar.ru)

Source: <https://delphiworld.narod.ru>

В разделе Заполнение изображением MDI-формы повторяющимся изображением.
Я нашел (Copyright не мой а из книжки) более простой способ.

    ...
    private
      OutCanvas: TCanvas;
      OldWinProc, NewWinProc: Pointer;
     
    procedure NewWinProcedure(var Msg: TMessage);
    ...
     
    procedure TMainForm.FormCreate(Sender: TObject);
    begin
      NewWinProc := MakeObjectInstance(NewWinProcedure);
      OldWinProc := Pointer(SetWindowLong(ClientHandle,
        gwl_WndProc, Cardinal(NewWinProc)));
      OutCanvas := TCanvas.Create;
    end;
     
    procedure TMainForm.NewWinProcedure(var Msg: TMessage);
    var
      BmpWidth, BmpHeight: Integer;
      I, J: Integer;
    begin
      // default processing first
      Msg.Result := CallWindowProc(OldWinProc,
        ClientHandle, Msg.Msg, Msg.wParam, Msg.lParam);
     
      // handle background repaint
      if Msg.Msg = wm_EraseBkgnd then
      begin
        BmpWidth := MainForm.Image1.Width;
        BmpHeight := MainForm.Image1.Height;
        if (BmpWidth <> 0) and (BmpHeight <> 0) then
        begin
          OutCanvas.Handle := Msg.wParam;
          for I := 0 to MainForm.ClientWidth div BmpWidth do
            for J := 0 to MainForm.ClientHeight div BmpHeight do
              OutCanvas.Draw(I * BmpWidth, J * BmpHeight,
                MainForm.Image1.Picture.Graphic);
        end;
      end;
    end;
     
    procedure TMainForm.FormDestroy(Sender: TObject);
    begin
      OutCanvas.Free;
    end;


------------------------------------------------------------------------

Вариант 6:

Author: [Nomadic](mailto:Nomadic@newmail.ru)

Source: <https://delphiworld.narod.ru>

    type
      .... = class(TForm)
        ....
          procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        ....
        private
        FHBrush: HBRUSH;
        FCover: TBitmap;
        FNewClientInstance: TFarProc;
        FOldClientInstance: TFarProc;
        procedure NewClientWndProc(var Message: TMessage);
        ....
        protected
        ....
          procedure CreateWnd; override;
        ....
      end;
     
      .....
     
    implementation
     
    {$R myRes.res} //pесуpс с битмапом фона
     
    procedure.FormCreate(...);
      var
      LogBrush: TLogbrush;
    begin
      FCover := TBitmap.Create;
      FCover.LoadFromResourceName(hinstance, 'BMPCOVER');
      with LogBrush do
      begin
        lbStyle := BS_PATTERN;
        lbHatch := FCover.Handle;
      end;
      FHBrush := CreateBrushIndirect(Logbrush);
    end;
     
      procedure.FormDestroy(...);
        begin
          DeleteObject(FHBrush);
          FCover.Free;
        end;
     
        procedure.CreateWnd;
        begin
          inherited CreateWnd;
          if (ClientHandle <> 0) then
          begin
            if NewStyleControls then
              SetWindowLong(ClientHandle, GWL_EXSTYLE, WS_EX_CLIENTEDGE or
                GetWindowLong(ClientHandle, GWL_EXSTYLE));
     
            FNewClientInstance := MakeObjectInstance(NewClientWndProc);
            FOldClientInstance := pointer(GetWindowLong(ClientHandle, GWL_WNDPROC));
            SetWindowLong(ClientHandle, GWL_WNDPROC, longint(FNewClientInstance));
          end;
        end;
     
        procedure.NewClientWndProc(var Message: TMessage);
     
          procedure Default;
          begin
            with Message do
              Result := CallWindowProc(FOldClientInstance, ClientHandle, Msg,
                wParam,
                lParam);
          end;
     
        begin
          with Message do
          begin
            case Msg of
              WM_ERASEBKGND:
                begin
                  FillRect(TWMEraseBkGnd(Message).DC, ClientRect, FHBrush);
                  Result := 1;
                end;
            else
              Default;
            end;
          end;
        end;

