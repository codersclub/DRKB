---
Title: Пример компонента типа XPButton
Date: 01.01.2007
Author: Jeff Caler (madmacs@netzero.net)
Source: <https://delphiworld.narod.ru>
---


Пример компонента типа XPButton
===============================

Раньше казалось, что невозможно было преодолеть нестабильность
Windows-98. Но теперь мы видим, что Windows XP ее в этом преодолела.

    unit GsXPButton;
    {
    written by Jeff Caler,
    Please use this responsibly and
    freely in your applications, modify, etc,
    but dont take credit for my work, i wouldnt yours,
    I reserve all rights given by copyright
    in the US and other countries.
    No right to resell this component or it's code is given nor implied.
    Enjoy it responsibly. As in, Dont take my name out and put in yours.
    Thank you.
    Jeff Caler
    madmacs@netzero.net
    GenieOS Software
    http://www.genieos.co.uk
    3-20-02
    }
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Buttons;
     
    type
      TGsXPButton = class(TSpeedButton)
      private
        { Private declarations }
        eColor, eSelBackColor, eSelFontColor, eSelBorderColor: TColor;
        FActive: boolean;
        FButtonDown: Boolean;
        FForm: TScrollingWinControl;
        FStyle: integer;
        FDefault: boolean;
        Procedure CMMouseEnter( Var Message: TMessage ); Message CM_MOUSEENTER;
        Procedure CMMouseLeave( Var Message: TMessage ); Message CM_MOUSELEAVE;
        procedure SetForm(const Value: TScrollingWinControl);
     
      protected
        { Protected declarations }
     
      public
        { Public declarations }
        Selected: Boolean;
        constructor Create( AOwner : TComponent ); override;
        property Form: TScrollingWinControl read FForm write SetForm;
        Procedure Paint; Override;
        procedure SetActive(const Value: boolean);
        procedure SetStyle (const Value: integer);
        procedure SetDefault(const Value: boolean);
        Procedure Style0(AOwner : TComponent);
        Procedure Style1(AOwner : TComponent);
      published
        { Published declarations }
        property Active: boolean read FActive write SetActive;
        Property Color: TColor read eColor write eColor;
        property Default: Boolean read FDefault write SetDefault;
        property Flat default True;
        Property SelBackColor: TColor read eSelBackColor write eSelBackColor;
        Property SelBorderColor: TColor read eSelBorderColor write eSelBorderColor;
        Property SelFontColor: TColor read eSelFontColor write eSelFontColor;
        Property Style: integer read FStyle write SetStyle;
     
      end;
     
    type
      TGsXPOkButton = class(TGsXPButton)
        private
        { Private declarations }
        protected
        { Protected declarations }
        public
        { Public declarations }
        constructor Create( AOwner : TComponent ); override;
        published
        { Published declarations }
      end;
     
      type
      TGsXPCancelButton = class(TGsXPButton)
        private
        { Private declarations }
        protected
        { Protected declarations }
        public
        { Public declarations }
        constructor Create( AOwner : TComponent );  override;
        published
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    constructor TGsXPButton.Create( AOwner : TComponent );
    begin
     
      inherited Create( AOwner );
      ControlStyle:= ControlStyle + [csAcceptsControls];
      Font.Color := clWindowText;
      Color := clBtnFace;
      FButtonDown := FALSE;
      Flat := True;
      FForm := Owner as TScrollingWinControl;
      Selected:= False;
      Height:= 22;
      SelFontColor := clHighLight;
      SelBackColor := clHighLightText;
      SelBorderColor := $0000A9E1;
      //Top:= 4;
      Transparent:= False;
      Width:= 65;
      Active := True;
      Style := 0;
    end;
     
    procedure TGsXPButton.SetStyle(const Value: integer);
    begin
      if FStyle <> Value then
      begin
        FStyle := Value;
      end;
    end;
     
    Procedure TGsXPButton.CMMouseEnter( Var Message: TMessage );
    Begin
      //hmmm, no selected property either ehhh.
     
      //Flicker GONE!
      If Selected = False then
      begin
        Selected := True;
        RePaint;
      end
      else
        Selected := True;
      exit;
     
    End;
     
     
    Procedure TGsXPButton.CMMouseLeave( Var Message: TMessage );
    Begin
      Selected:= False;
      FButtonDown := FALSE;
      RePaint;
      IF Selected = False then exit;
    End;
     
    procedure TGsXPButton.SetForm(const Value: TScrollingWinControl);
    var
      Hold: boolean;
    begin
      if Value <> FForm then
      begin
        Hold := Active;
        Active := false;
        FForm := Value;
        if Hold then
          Active := True;
      end;
    end;
     
    procedure TGsXPButton.SetActive(const Value: boolean);
    begin
      FActive := Value;
    end;
     
    procedure TGsXPButton.SetDefault(const Value: boolean);
    begin
      FDefault := Value;
    end;
     
    function NewColor(Canvas: TCanvas; clr: TColor; Value: integer): TColor;
    var
      r, g, b: integer;
     
    begin
      if Value > 100 then Value := 100;
      clr := ColorToRGB(clr);
      r := Clr and $000000FF;
      g := (Clr and $0000FF00) shr 8;
      b := (Clr and $00FF0000) shr 16;
     
      r := r + Round((255 - r) * (value / 100));
      g := g + Round((255 - g) * (value / 100));
      b := b + Round((255 - b) * (value / 100));
     
      Result := Windows.GetNearestColor(Canvas.Handle, RGB(r, g, b));
     
    end;
     
    Procedure TGsXPButton.style0(AOwner : TComponent);
    var
      Gbtn: TGsXPButton;
      Right, Bottom: integer;
      Selector, txtRect, ARect, iconRect, FRect: TRect;
      FColor, FSelBackColor, FSelFontColor: TColor;
      FSelBorderColor: TColor;
      SelText: String;
      TextFormat: integer;
      x1, y1 : integer;
      i,v : integer;
      CWidth, CHeight: INTEGER;
    begin
      inherited;
      Gbtn:= TGsXPButton(Self);
      FColor := eColor;
      FSelBackColor := eSelBackColor;
      FSelFontColor := eSelFontColor;
      Bottom := (Gbtn.Canvas.ClipRect.Bottom);
      Right := (Gbtn.Canvas.ClipRect.Right);
      ARect.Top := (Gbtn.Canvas.ClipRect.Top);
      ARect.Right := Right;
      ARect.Bottom := Bottom;
      Arect.Left := (Gbtn.Canvas.ClipRect.Left);
      TextFormat := DT_Left;
      SelText :=( '  ' + (Gbtn.Caption));
     
      If Gbtn.Active then
        Gbtn.Style := 0;
      begin
        Flat:= True;
        font.Color := font.Color;
        Color := FColor;
 
        Selector := Rect( ARect.Left, ARect.Top,
        ARect.right, ARect.bottom );
 
        FRect:= Rect(Arect.Left+3,Arect.Top +3,
        Arect.Right -3, Arect.Bottom -3);
 
        //capture the image rect and layout image and text
        //Heavy on the math...
     
        if not Glyph.Empty then
        begin
          if Layout = blGlyphLeft then
          begin
            SelText:= SelText;
     
            iconRect:=(Glyph.Canvas.ClipRect);
            CWidth:=(Glyph.Width + Canvas.TextWidth(SelText));
     
            iconRect.Left := (ARect.Right - CWidth) div 2;
            iconRect.Top := (ARect.Bottom - Glyph.Height) div 2 ;
            iconRect.Right := (iconRect.Left + Glyph.Width);
            iconRect.Bottom := (iconRect.Top + Glyph.Height);
            x1:= (iconRect.Right);
            y1:= (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
            TxtRect:= Rect (X1,Y1, Selector.Right, Selector.Bottom );
          end
          else
            if Layout = blGlyphRight then begin
              Seltext := SelText + '  ';
     
              iconRect:=(Glyph.Canvas.ClipRect);
              CWidth:=(Glyph.Width + Canvas.TextWidth(SelText));
              TxtRect:= (Gbtn.Canvas.ClipRect);
       
              TxtRect.Left := (ARect.Right - CWidth) div 2;
              TxtRect.Top := (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
              TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
              TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
       
              IconRect.Left := (TxtRect.Right);
              iconRect.Top := (ARect.Bottom - Glyph.Height) div 2 ;
              iconRect.Right := (iconRect.Left + Glyph.Width);
              iconRect.Bottom := (iconRect.Top + Glyph.Height);
            end
            else
              if Layout = blGlyphTop then begin
                SelText := SelText;
                iconRect:=(Glyph.Canvas.ClipRect);
                CHeight:= (Canvas.TextHeight(SelText)+ Glyph.Height);
         
                TxtRect:= (Gbtn.Canvas.ClipRect);
         
                IconRect.Left := (Canvas.ClipRect.Right div 2) - (glyph.Width div 2);
                iconRect.Top := (ARect.Bottom div 2) - ((glyph.Height + Canvas.TextHeight(Seltext)) div 2) ;
                iconRect.Right := (iconRect.Left + Glyph.Width);
                iconRect.Bottom := (iconRect.Top + Glyph.Height);
         
                TxtRect.Left := (ARect.Right div 2) - (Canvas.TextWidth(Seltext) div 2);
                TxtRect.Top := (iconRect.Bottom + 2);
                TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
                TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
              end
              else
                if Layout = blGlyphBottom then begin
                  SelText := SelText;
                  iconRect:=(Glyph.Canvas.ClipRect);
                  CHeight:= (Canvas.TextHeight(SelText)+ Glyph.Height);
           
                  TxtRect:= (Gbtn.Canvas.ClipRect);
           
                  TxtRect.Left := (ARect.Right div 2) - (Canvas.TextWidth(Seltext) div 2);
                  TxtRect.Top := (ARect.Bottom div 2) - ((glyph.Height + Canvas.TextHeight(Seltext)) div 2) ;
                  TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
                  TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
           
                  IconRect.Left := (Canvas.ClipRect.Right div 2) - (glyph.Width div 2);
                  iconRect.Top := (txtRect.Bottom + 2) ;
                  iconRect.Right := (iconRect.Left + Glyph.Width);
                  iconRect.Bottom := (iconRect.Top + Glyph.Height);
                end;
        end
        else
          if Glyph.Empty Then
          begin
            SelText := SelText;
            x1:= (Arect.Right - Canvas.TextWidth(SelText))div 2;
            y1:= (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
            TxtRect:= Rect (X1,Y1, Selector.Right, Selector.Bottom );
          end;
     
          Canvas.Brush.Style:= bsSolid;
          Canvas.Brush.Color := FColor;
          Canvas.FillRect(ARect);
     
          IF GBtn.Default THEN
            IF not Selected then
              If not Gbtn.MouseCapture then
              begin
                v:=0;
                Selector.top := Selector.bottom - 1;
                for i := ARect.bottom downto ARect.top do
                begin
                  if (Selector.top < ARect.bottom)
                     and (Selector.top > Arect.bottom + 5) then
                    inc(v, 1)
                  else
                    inc(v, 2);
     
                  if v > 96 then v := 96;
     
                  Canvas.Brush.Color := NewColor(Canvas, $00FF8080, v);
                  Canvas.FillRect(Selector);
                  Selector.top := Selector.top -1;
                  Selector.bottom := Selector.top + 1;
             
                  Canvas.Brush.Style := bsClear;
                  Canvas.Pen.color := $00984E00;
                  Canvas.RoundRect(ARect.Left,

                  Arect.top, Arect.right,
                  Arect.bottom, 5, 5);
     
                  Canvas.Brush.Style:= bsSolid;
                  Canvas.Brush.Color := FSelBackColor;
                  Canvas.FillRect(FRect);
     
                  //draw the text
     
                  DrawtextEx(Gbtn.Canvas.Handle,
                  PChar(SelText),
                  Length(SelText),
                  txtRect,
                  TextFormat, nil);
                  
                  if not gbtn.Glyph.Empty THEN Canvas.Rectangle (iconRect);
                  begin
                    Canvas.CopyRect(IconRect,Canvas,(GBtn.Glyph.Canvas.ClipRect));
                    Canvas.BrushCopy (IconRect, Glyph,(GBtn.Glyph.Canvas.ClipRect),(clBlue));
                    Gbtn.Glyph.FreeImage;
                  end;
                end;
              end;
     
              If Gbtn.Selected then
                if not gbtn.MouseCapture then
                begin
                  //gradient begin
                  v:=0;
                  Selector.top := Selector.bottom - 1;
                  for i := ARect.bottom downto ARect.top do
                  begin
                    if (Selector.top < ARect.bottom)
                       and (Selector.top > Arect.bottom + 5) then
                      inc(v, 1)
                    else
                      inc(v, 3);
     
                    if v > 96 then v := 96;
     
                    Canvas.Brush.Color := NewColor(Canvas, $0000A9E1, v);
                    Canvas.FillRect(Selector);
               
                    Selector.top := Selector.top -1;
                    Selector.bottom := Selector.top + 1;
               
                    Canvas.Brush.Style := bsClear;
                    Canvas.Pen.color := $00984E00;
                    Canvas.RoundRect(ARect.Left,
                    
                    Arect.top, Arect.right,
                    Arect.bottom, 5, 5);
     
                    Canvas.Brush.Style:= bsSolid;
                    Canvas.Brush.Color := FSelBackColor;
                    Canvas.FillRect(FRect);
                    Canvas.Font.color := FSelFontColor;
     
                    DrawtextEx(Gbtn.Canvas.Handle,
                    PChar(SelText),
                    Length(SelText),
                    txtRect,
                    TextFormat, nil);
     
                    if not gbtn.Glyph.Empty THEN Canvas.Rectangle (iconRect);
                    begin
                      Canvas.CopyRect(IconRect,Canvas,(GBtn.Glyph.Canvas.ClipRect));
                      Canvas.BrushCopy (IconRect, Glyph,(GBtn.Glyph.Canvas.ClipRect),(clBlue));
                      Gbtn.Glyph.FreeImage;
                    end;
                  end;
                end;
     
     
     
              //draw the  outline
              Canvas.Brush.Style := bsClear;
              Canvas.Pen.color := $00984E00;
              Canvas.RoundRect(ARect.Left,
               
              ARect.top, ARect.right,
              ARect.bottom, 5, 5);
     
              //override the button canvas
              Canvas.Brush.Style := bsSolid;
              Canvas.Brush.Color:= FColor;
              Canvas.FillRect(Frect);
       
              //over ride the text
              DrawtextEx(Gbtn.Canvas.Handle, PChar(SelText),
                Length(SelText), txtRect, TextFormat, nil);
     
              if not gbtn.Glyph.Empty THEN Canvas.Rectangle (iconRect);
              begin
                Canvas.CopyRect(IconRect,Canvas,(GBtn.Glyph.Canvas.ClipRect));
                Canvas.BrushCopy (IconRect, Glyph,(GBtn.Glyph.Canvas.ClipRect),(clBlue));
                gbtn.Glyph.FreeImage;
              end;
          end;
     
    end;
     
    Procedure TGsXPButton.Style1(AOwner : TComponent);
    var
      Gbtn: TGsXPButton;
      Right, Bottom: integer;
      Selector, txtRect, ARect, iconRect, FRect: TRect;
      FColor, FSelBackColor, FSelFontColor: TColor;
      FSelBorderColor: TColor;
      SelText: String;
      TextFormat: integer;
      x1, y1 : integer;
      i,v : integer;
      CWidth, CHeight: INTEGER;
    begin
      inherited;
      //let the games begin
      Gbtn:= TGsXPButton(Self);
      FColor := eColor;
      FSelBackColor := eSelBackColor;
      FSelFontColor := eSelFontColor;
      Bottom := (Gbtn.Canvas.ClipRect.Bottom);
      Right := (Gbtn.Canvas.ClipRect.Right);
      ARect.Top := (Gbtn.Canvas.ClipRect.Top);
      ARect.Right := Right;
      ARect.Bottom := Bottom;
      Arect.Left := (Gbtn.Canvas.ClipRect.Left);
      TextFormat := DT_Left;
      SelText :=( '  ' + (Gbtn.Caption));
     
      If Gbtn.Active then
        Gbtn.Style := 1;
      begin
        Flat:= True;
        font.Color := font.Color;
        Color := FColor;
         
        Selector := Rect( ARect.Left, ARect.Top,
        ARect.right, ARect.bottom );
 
        FRect:= Rect(Arect.Left+3,Arect.Top +3,
        Arect.Right -3, Arect.Bottom -3);
 
        //capture the image rect and layout image and text
        //Heavy on the math...
     
        if not Glyph.Empty then
        begin
          if Layout = blGlyphLeft then
          begin
            SelText:= SelText;
     
            iconRect:=(Glyph.Canvas.ClipRect);
            CWidth:=(Glyph.Width + Canvas.TextWidth(SelText));
     
            iconRect.Left := (ARect.Right - CWidth) div 2;
            iconRect.Top := (ARect.Bottom - Glyph.Height) div 2 ;
            iconRect.Right := (iconRect.Left + Glyph.Width);
            iconRect.Bottom := (iconRect.Top + Glyph.Height);
            x1:= (iconRect.Right);
            y1:= (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
            TxtRect:= Rect (X1,Y1, Selector.Right, Selector.Bottom );
          end
          else
            if Layout = blGlyphRight then
            begin
              Seltext := SelText + '  ';
       
              iconRect:=(Glyph.Canvas.ClipRect);
              CWidth:=(Glyph.Width + Canvas.TextWidth(SelText));
              TxtRect:= (Gbtn.Canvas.ClipRect);
       
              TxtRect.Left := (ARect.Right - CWidth) div 2;
              TxtRect.Top := (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
              TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
              TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
       
              IconRect.Left := (TxtRect.Right);
              iconRect.Top := (ARect.Bottom - Glyph.Height) div 2 ;
              iconRect.Right := (iconRect.Left + Glyph.Width);
              iconRect.Bottom := (iconRect.Top + Glyph.Height);
            end
            else
              if Layout = blGlyphTop then
              begin
                SelText := SelText;
                iconRect:=(Glyph.Canvas.ClipRect);
                CHeight:= (Canvas.TextHeight(SelText)+ Glyph.Height) div 2;
         
                TxtRect:= (Gbtn.Canvas.ClipRect);
         
                IconRect.Left := (Canvas.ClipRect.Right div 2) - (glyph.Width div 2);
                iconRect.Top := (ARect.Bottom div 2) - (CHeight) ;
                iconRect.Right := (iconRect.Left + Glyph.Width);
                iconRect.Bottom := (iconRect.Top + Glyph.Height);
         
                TxtRect.Left := (ARect.Right div 2) - (Canvas.TextWidth(Seltext) div 2);
                TxtRect.Top := (iconRect.Bottom + 2);
                TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
                TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
              end
              else
                if Layout = blGlyphBottom then
                begin
                  SelText := SelText;
                  iconRect:=(Glyph.Canvas.ClipRect);
                  TxtRect:= (Gbtn.Canvas.ClipRect);
           
                  TxtRect.Left := (ARect.Right div 2) - (Canvas.TextWidth(Seltext) div 2);
                  TxtRect.Top := (ARect.Bottom div 2) - ((glyph.Height + Canvas.TextHeight(Seltext)) div 2) ;
                  TxtRect.Right := (TxtRect.Left + Canvas.TextWidth(SelText));
                  TxtRect.Bottom := (TxtRect.Top + Canvas.TextHeight(SelText));
           
                  IconRect.Left := (Canvas.ClipRect.Right div 2) - (glyph.Width div 2);
                  iconRect.Top := (txtRect.Bottom + 2) ;
                  iconRect.Right := (iconRect.Left + Glyph.Width);
                  iconRect.Bottom := (iconRect.Top + Glyph.Height);
                end;
            end
            else
              if Glyph.Empty Then
              begin
                SelText := SelText;
                x1:= (Arect.Right - Canvas.TextWidth(SelText))div 2;
                y1:= (Arect.Bottom - Canvas.TextHeight(SelText)) div 2;
                TxtRect:= Rect (X1,Y1, Selector.Right, Selector.Bottom );
              end;
     
          Canvas.Brush.Style:= bsSolid;
          Canvas.Brush.Color := FColor;
          Canvas.FillRect(ARect);
     
          IF GBtn.Default THEN
            IF not Selected then
              If not Gbtn.MouseCapture then
              begin
                v:=0;
                Selector.top := Selector.bottom - 1;
                for i := ARect.bottom downto ARect.top do
                begin
                  if (Selector.top < ARect.bottom)
                     and (Selector.top > Arect.bottom + 5) then
                    inc(v, 1)
                  else
                    inc(v, 2);
     
                  if v > 96 then v := 96;
     
                  Canvas.Brush.Color := NewColor(Canvas, $00FF8080, v);
                  Canvas.FillRect(Selector);
                  Selector.top := Selector.top -1;
                  Selector.bottom := Selector.top + 1;
             
                  Canvas.Brush.Style := bsClear;
                  Canvas.Pen.color := $00984E00;
                  Canvas.Rectangle(ARect.Left,
                  
                  Arect.top, Arect.right,
                  Arect.bottom );
     
                  Canvas.Brush.Style:= bsSolid;
                  Canvas.Brush.Color := FSelBackColor;
                  Canvas.FillRect(FRect);
     
                  //draw the text
     
                  DrawtextEx(Gbtn.Canvas.Handle,
                  PChar(SelText),
                  Length(SelText),
                  txtRect,
                  TextFormat, nil);
           
                end;
             end;
     
             If Gbtn.Selected then
            if not gbtn.MouseCapture then
          begin
           //gradient begin
                      v:=0;
        Selector.top := Selector.bottom - 1;
        for i := ARect.bottom downto ARect.top do
        begin
          if (Selector.top < ARect.bottom)
            and (Selector.top > Arect.bottom + 5) then
            inc(v, 1)
          else
            inc(v, 3);
     
          if v > 96 then v := 96;
     
     
          Canvas.Brush.Color := NewColor(Canvas, $0000A9E1, v);
          Canvas.FillRect(Selector);
     
          Selector.top := Selector.top -1;
          Selector.bottom := Selector.top + 1;
     
          Canvas.Brush.Style := bsClear;
          Canvas.Pen.color := $00984E00;
          Canvas.Rectangle(ARect.Left,
                    Arect.top, Arect.right,
                    Arect.bottom );
     
          Canvas.Brush.Style:= bsSolid;
          Canvas.Brush.Color := FSelBackColor;
          Canvas.FillRect(FRect);
     
     
           Canvas.Font.color := FSelFontColor;
     
     
            DrawtextEx(Gbtn.Canvas.Handle,
            PChar(SelText),
            Length(SelText),
            txtRect,
            TextFormat, nil);
     
         end;
     end;
     
            //draw the  outline
            Canvas.Brush.Style := bsClear;
            Canvas.Pen.color := $00984E00;
            Canvas.Rectangle(ARect.Left,
                    ARect.top, ARect.right,
                    ARect.bottom);
     
            //override the button canvas
            Canvas.Brush.Style := bsSolid;
            Canvas.Brush.Color:= FColor;
            Canvas.FillRect(Frect);
     
            //over ride the text
                     DrawtextEx(Gbtn.Canvas.Handle,
            PChar(SelText),
            Length(SelText),
            txtRect,
            TextFormat, nil);
     
                    if not gbtn.Glyph.Empty THEN Canvas.Rectangle (iconRect);
                  begin
                  Canvas.CopyRect(IconRect,Canvas,(GBtn.Glyph.Canvas.ClipRect));
                  Canvas.BrushCopy (IconRect, Glyph,(GBtn.Glyph.Canvas.ClipRect),(clBlue));
                  gbtn.Glyph.FreeImage;
                    end;
        end;
     
    end;
     
    Procedure TGsXPButton.Paint;
    var
      Gbtn: TGsXPButton;
    begin
      //this grabs all the speedbuttons properties
      inherited;
      //protect our design environment
      if not (csDesigning in ComponentState) then
      begin
        Gbtn:= TGsXPButton(Self);
     
        If Gbtn.Active then
          If Gbtn.Style = 0 then
          begin
            Style0(Self);
          end
        else
        If Gbtn.Style = 1 then
        begin
          Style1(Self);
        end;
      end;
    end;
     
    //Begin Ok Button
    //inherits from the GSXPButton. only caption changed
    //same for cancel button.
    //make mods to main button, changes are inherited.
     
    constructor TGsXPOkButton.Create( AOwner : TComponent );
    begin
      // Don't forget to call the ancestor's constructor
      inherited Create( AOwner );
      Caption := '&OK';
     
    end;
     
    //Begin Cancel Button
     
    constructor TGsXPCancelButton.Create( AOwner : TComponent );
    begin
      inherited Create( AOwner );
      Caption := '&Cancel';
    end;
     
    procedure Register;
    begin
      RegisterComponents('GenieOSTools', [TGsXPButton, TGsXPOKButton, TGsXPCancelButton]);
    end;
     
    end.

