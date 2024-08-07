---
Title: Компонент TFontListBox
Author: Maarten de Haan
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Компонент TFontListBox
======================

Надеюсь, что любители Delphi уже не один раз приукрашивали всякие
ЛистБоксы и тому подобное. Автор исходника предлагает создать этот
компонент своими силами. Впрочем, Вы сами можете увидеть как можно
играться со шрифтами в ListBox.

    { 
    ==================================================================
                        Написан в Delphi V5.0. 
        Тестировался под:  Windows 95, version A, servicepack 1 
                  и   Windows NT4.0, servicepack 5. 
    ===================================================================  
    } 
    Unit FontListBox; 
     
    Interface 
     
    Uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, 
      Forms, Dialogs, StdCtrls; 
     
    Type 
      TFontListBox = class(TCustomListbox) 
     
      Private 
        { Private declarations } 
        fFontSample      : Boolean;             // Добавляемое свойство 
        fShowTrueType    : Boolean;             // Добавляемое свойство 
        fCanvas          : TControlCanvas;      // Необходимо 
     
        Procedure SetFontSample(B : Boolean);   // внутренняя процедура 
        Procedure SetShowTrueType(B : Boolean); // внутренняя процедура 
     
      Protected 
        { Protected declarations } 
        Procedure CreateWnd; override; 
     
      Public 
        { Public declarations } 
        Constructor Create(AOwner : TComponent); override; 
        Destructor Destroy; override; 
        Procedure DrawItem(Index : Integer; R : TRect; 
           State : TOwnerDrawState); override; 
     
      Published 
        { Published declarations } 
        { Properties } 
        Property Fontsample : Boolean           // Добавляемое свойство 
           Read fFontSample Write SetFontSample; 
        Property Align; 
        Property Anchors; 
        Property BiDiMode; 
        Property BorderStyle; 
        Property Color; 
        Property Columns; 
        Property Constraints; 
        Property Cursor; 
        Property DragCursor; 
        Property DragKind; 
        Property DragMode; 
        Property Enabled; 
        //Poperty ExtendedSelection; Не существует в базовом классе 
        Property Font; 
        Property Height; 
        Property HelpContext; 
        Property Hint; 
        Property ImeMode; 
        Property ImeName; 
        Property IntegralHeight; 
        Property Itemheight; 
        Property Items; 
        Property Left; 
        Property MultiSelect; 
        Property Name; 
        Property ParentBiDiMode; 
        Property ParentColor; 
        Property ParentFont; 
        Property ParentShowHint; 
        Property PopupMenu; 
        Property ShowTrueType : Boolean         // Добавляемое свойство 
           Read fShowTrueType Write SetShowTrueType; 
        Property ShowHint; 
        Property Sorted; 
        Property Style; 
        Property TabOrder; 
        Property TabStop; 
        Property TabWidth; 
        Property Tag; 
        Property Top; 
        Property Visible; 
        Property Width; 
        { Events } 
        Property OnClick; 
        Property OnContextPopup; 
        Property OnDblClick; 
        Property OnDragDrop; 
        Property OnDragOver; 
        Property OnDrawItem; 
        Property OnEndDock; 
        Property OnEnter; 
        Property OnExit; 
        Property OnKeyDown; 
        Property OnKeyPress; 
        Property OnKeyUp; 
        Property OnMeasureItem; 
        Property OnMouseDown; 
        Property OnMouseMove; 
        Property OnMouseUp; 
        Property OnStartDock; 
        Property OnStartDrag; 
      End; 
     
    Procedure Register; 
     
    Implementation 
     
    {--------------------------------------------------------------------} 
    Procedure Register; // Hello 
     
    Begin 
    RegisterComponents('Samples', [TFontListBox]); 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TFontListBox.SetShowTrueType(B : Boolean); 
     
    Begin 
    If B <> fShowTrueType then 
       Begin 
       fShowTrueType := B; 
       Invalidate; // Заставляет апдейтится во время прорисовки 
       End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TFontListBox.SetFontSample(B : Boolean); 
     
    Begin 
    If fFontSample <> B then 
       Begin 
       fFontSample := B; 
       Invalidate; // Заставляет апдейтится во время прорисовки 
       End; 
    End; 
    {--------------------------------------------------------------------} 
    Destructor TFontListBox.Destroy; 
     
    Begin 
      fCanvas.Free;      // освобождает холст 
      Inherited Destroy; 
    End; 
    {-----------------------------------------------------------------------} 
    Constructor TFontListBox.Create(AOwner : TComponent); 
     
    Begin 
      Inherited Create(AOwner); 
      // Initialize properties 
      ParentFont := True; 
      Font.Size := 8; 
      Font.Style := []; 
      Sorted := True; 
      fFontSample := False; 
      Style := lbOwnerDrawFixed; 
      fCanvas := TControlCanvas.Create; 
      fCanvas.Control := Self; 
      ItemHeight := 16; 
      fShowTrueType := False; 
    End; 
    {--------------------------------------------------------------------} 
    procedure TFontListBox.CreateWnd; 
     
    Begin 
      inherited CreateWnd; 
      Items := Screen.Fonts; // Копируем все шрифты в ListBox.Items 
      ItemIndex := 0;        // Выбираем первый фонт 
    End; 
    {--------------------------------------------------------------------} 
    procedure TFontListBox.DrawItem(Index : Integer; R : TRect; 
       State : TOwnerDrawState); 
     
    Var 
       Metrics           : TTextMetric; 
       LogFnt            : TLogFont; 
       oldFont,newFont   : HFont; 
       IsTrueTypeFont    : Boolean; 
       fFontStyle        : TFontStyles; 
       fFontName         : TFontName; 
       fFontColor        : TColor; 
     
    Begin 
      LogFnt.lfHeight := 10; 
      LogFnt.lfWidth := 10; 
      LogFnt.lfEscapement := 0; 
      LogFnt.lfWeight := FW_REGULAR; 
      LogFnt.lfItalic := 0; 
      LogFnt.lfUnderline := 0; 
      LogFnt.lfStrikeOut := 0; 
      LogFnt.lfCharSet := DEFAULT_CHARSET; 
      LogFnt.lfOutPrecision := OUT_DEFAULT_PRECIS; 
      LogFnt.lfClipPrecision := CLIP_DEFAULT_PRECIS; 
      LogFnt.lfQuality := DEFAULT_QUALITY; 
      LogFnt.lfPitchAndFamily := DEFAULT_PITCH or FF_DONTCARE; 
      StrPCopy(LogFnt.lfFaceName,Items[Index]); 
      newFont := CreateFontIndirect(LogFnt); 
      oldFont := SelectObject(fCanvas.Handle,newFont); 
      GetTextMetrics(fCanvas.Handle,Metrics); 
      // Теперь вы можете проверить на TrueType-ность 
      IsTrueTypeFont := True; 
      If (Metrics.tmPitchAndFamily and TMPF_TRUETYPE) = 0 then 
         IsTrueTypeFont := False; 
       
      Canvas.FillRect(R); 
      If fShowTrueType and IsTrueTypeFont then 
         Begin 
         // Записываем параметры шрифтов 
         fFontName := Canvas.Font.Name; 
         fFontStyle := Canvas.Font.Style; 
         fFontColor := Canvas.Font.Color; 
         // Устанавливаем новые параметры шрифтов 
         Canvas.Font.Name := 'Times new roman'; 
         Canvas.Font.Style := [fsBold]; 
         //Canvas.Font.Color := clBlack; 
         Canvas.TextOut(R.Left + 2,R.Top,'T'); 
         If fFontColor <> clHighLightText then 
            Canvas.Font.Color := clGray; 
         Canvas.TextOut(R.Left + 7,R.Top + 3,'T'); 
         //Восстанавливаем параметры шрифтов 
         Canvas.Font.Style := fFontStyle; 
         Canvas.Font.Color := fFontColor; 
         Canvas.Font.Name := fFontName; 
         End; 
       
      If fFontSample then 
         // Шрифт будет прорисован фактически как шрифт 
         Canvas.Font.Name :=  Items[Index] 
      else 
         // Шрифт будет прорисован в свойстве "Font" 
         Canvas.Font.Name :=  Font.Name; 
       
      If fShowTrueType then 
         Canvas.TextOut(R.Left + 20,R.Top,Items[Index]) // Показывать TrueType 
      else 
         Canvas.TextOut(R.Left,R.Top,Items[Index]); // Не показывать TrueType 
       
      SelectObject(fCanvas.Handle,oldFont); 
      DeleteObject(newFont); 
    End; 
    {--------------------------------------------------------------------} 
    End. 
    {====================================================================} 

