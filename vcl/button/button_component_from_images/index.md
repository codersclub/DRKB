---
Title: Можно ли из 3-х картинок сделать компонент-кнопку?
Date: 12.12.2005
Author: Михаил Мостовой (s-mike) http://mikesoft.front.ru
Source: http://forum.sources.ru
---


Можно ли из 3-х картинок сделать компонент-кнопку?
==================================================

> Мастера, у меня назрел еще такой вопрос! Можно ли из 3-х Image (картинок)
> сделать компонент-кнопку?
> т.е у меня есть три картинки: кнопка обычная,
> нажатая и активная (на ней курсор мышки)?
> Я конечно могу каждый раз на
> форму кидать по три Image, вставляя в каждый Image картинку, но это
> только на одну кнопку 3 image\'a, а если я хочу 10 кнопок, то это будет
> уже 30 image\'ей!!! Я представляю, что у кнопки должны быть такие
> свойства как у Image\'a, и в свойствах этого компонета дожны быть ссылки
> на 3 картинки, отвечающие нужному состоянию. Сразу скажу, что BitBtn не
> подойдет, так как форма кнопки прямоугольником и не повторяет форму
> рисунка в картинки. Компонент Image он тоже прямоугольный, но если
> всавить в него картинку и назначить свойство Transparent, Image станет
> при этом позрачный и повторит форму рисунка в картинке, т.е. рисунка
> кнопки.

Вот пример использования спрайта:

    {*******************************************************}
    {                                                       }
    {       Sprite Button                                   }
    {                                                       }
    {       Copyright (c) 2004-2005, Михаил Мостовой        }
    {                                (s-mike)               }
    {       http://forum.sources.ru                         }
    {       http://mikesoft.front.ru                        }
    {                                                       }
    {*******************************************************}
     
    unit SpriteBtn;
     
    interface
     
    uses
      Windows, SysUtils, Classes, Controls, Graphics, Types, Messages;
     
    type
      TSpriteButton = class(TGraphicControl)
      private
        FPicturePressed: TPicture;
        FPictureFocused: TPicture;
        FPictureNormal: TPicture;
        FPictureDisabled: TPicture;
        FEnabled: Boolean;
        FPressed: Boolean;
        FFocused: Boolean;
        FDrawing: Boolean;
        FTransparent: Boolean;
        procedure SetPictureFocused(const Value: TPicture);
        procedure SetPicturePressed(const Value: TPicture);
        procedure SetPictureNormal(const Value: TPicture);
        procedure SetPictureDisabled(const Value: TPicture);
        procedure CMMouseEnter(var Message: TMessage); message CM_MOUSEENTER;
        procedure CMMouseLeave(var Message: TMessage); message CM_MOUSELEAVE;
        procedure OnPictureChange(Sender: TObject);
        procedure UpdateButtonState;
        procedure SetTransparent(const Value: Boolean);
      protected
        procedure Paint; override;
        procedure MouseDown(Button: TMouseButton; Shift: TShiftState; X, Y: Integer); override;
        procedure MouseUp(Button: TMouseButton; Shift: TShiftState; X, Y: Integer); override;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
      published
        property Action;
        property Anchors;
        property Caption;
        property Enabled;
        property Font;
        property ShowHint;
        property ParentShowHint;
        property OnClick;
        property OnMouseDown;
        property PictureNormal: TPicture read FPictureNormal write SetPictureNormal;
        property PictureFocused: TPicture read FPictureFocused write SetPictureFocused;
        property PicturePressed: TPicture read FPicturePressed write SetPicturePressed;
        property PictureDisabled: TPicture read FPictureDisabled write SetPictureDisabled;
        property Transparent: Boolean read FTransparent write SetTransparent;
      end;
     
    procedure Register;
     
    implementation
     
    uses Consts;
     
    procedure Register;
    begin
      RegisterComponents('MSX Controls', [TSpriteButton]);
    end;
     
    { TSpriteButton }
     
    constructor TSpriteButton.Create(AOwner: TComponent);
    begin
      inherited;
     
      FEnabled := True;
     
      FPictureNormal := TPicture.Create;
      FPictureNormal.OnChange := OnPictureChange;
      FPictureFocused := TPicture.Create;
      FPicturePressed := TPicture.Create;
      FPictureDisabled := TPicture.Create;
     
      FPressed := False;
      FFocused := False;
     
      FDrawing := False;
    end;
     
    destructor TSpriteButton.Destroy;
    begin
      FPictureNormal.Free;
      FPictureFocused.Free;
      FPicturePressed.Free;
      FPictureDisabled.Free;
     
      inherited;
    end;
     
    procedure TSpriteButton.SetPictureNormal(const Value: TPicture);
    begin
      PictureNormal.Assign(Value);
      if Assigned(Value) then
      begin
        Width := Value.Width;
        Height := Value.Height;
      end;
      if not FDrawing then Invalidate;
    end;
     
    procedure TSpriteButton.SetPictureFocused(const Value: TPicture);
    begin
      FPictureFocused.Assign(Value);
    end;
     
    procedure TSpriteButton.SetPicturePressed(const Value: TPicture);
    begin
      FPicturePressed.Assign(Value);
    end;
     
    procedure TSpriteButton.SetPictureDisabled(const Value: TPicture);
    begin
      FPictureDisabled.Assign(Value);
    end;
     
    procedure TSpriteButton.CMMouseEnter(var Message: TMessage);
    begin
      if Enabled = False then Exit;
     
      FFocused := True;
      if not FDrawing then Invalidate;
    end;
     
    procedure TSpriteButton.CMMouseLeave(var Message: TMessage);
    begin
      if Enabled = False then Exit;
     
      FFocused := False;
      if not FDrawing then Invalidate;
    end;
     
    procedure TSpriteButton.MouseDown(Button: TMouseButton; Shift: TShiftState;
      X, Y: Integer);
    begin
      inherited;
     
      if Enabled = False then Exit;
     
      if Button = mbLeft then
      begin
        FPressed := True;
        FFocused := True;
        if not FDrawing then Invalidate;
      end;
    end;
     
    procedure TSpriteButton.MouseUp(Button: TMouseButton; Shift: TShiftState;
      X, Y: Integer);
    begin
      if Enabled = False then Exit;
     
      if Button = mbLeft then
      begin
        FPressed := False;
        if not FDrawing then Invalidate;
      end;
     
      inherited;  
    end;
     
    procedure TSpriteButton.OnPictureChange(Sender: TObject);
    begin
      Width := PictureNormal.Width;
      Height := PictureNormal.Height;
      if not FDrawing then Invalidate;
    end;
     
    procedure TSpriteButton.UpdateButtonState;
    var
      Picture: TPicture;
    begin
      if Enabled then
      begin
        if not (csDesigning in ComponentState) then
        begin
          if (FPressed and FFocused) then
            Picture := PicturePressed
          else
            if (not FPressed and FFocused) then
              Picture := PictureFocused
            else
              Picture := PictureNormal;
        end else Picture := PictureNormal;
      end else begin
        FFocused := False;
        FPressed := False;
        Picture := PictureDisabled;
      end;
     
      if (Picture <> PictureNormal) and ((Picture.Width = 0) or (Picture.Height = 0)) then
        Picture := PictureNormal; 
     
      if (csDesigning in ComponentState) and
         ((not Assigned(Picture.Graphic)) or (Picture.Width = 0) or (Picture.Height = 0)) then
      begin
        with Canvas do
        begin
          Pen.Style := psDash;
          Pen.Color := clBlack;
          Brush.Color := Color;
          Brush.Style := bsSolid;
          Rectangle(0, 0, Width, Height);
        end;
     
        Exit;
      end;
     
      if Assigned(Picture.Graphic) then
      begin
        if not ((Picture.Graphic is TMetaFile) or (Picture.Graphic is TIcon)) then
          Picture.Graphic.Transparent := FTransparent;
     
        Canvas.Draw(0, 0, Picture.Graphic);
      end;
    end;
     
    procedure TSpriteButton.Paint;
    var
      R: TRect;
    begin
      if FDrawing then Exit;
     
      FDrawing := True;
      try
        UpdateButtonState;
     
        if Caption <> '' then
        begin
          R := ClientRect;
          Canvas.Font.Assign(Font);
          Canvas.Brush.Style := bsClear;
     
          R := ClientRect;
          R.Top := 0;
          R.Bottom := 0;
          Inc(R.Left, 14);
          Dec(R.Right, 14);
          DrawText(Canvas.Handle, PChar(Caption), -1, R, DT_WORDBREAK or DT_CALCRECT);
     
          R.Right := ClientWidth - 14;
          R.Top := (ClientHeight - (R.Bottom - R.Top)) div 2;
          R.Bottom := ClientHeight;
     
          DrawText(Canvas.Handle, PChar(Caption), -1, R, DT_WORDBREAK or DT_CENTER);
        end;
      finally
        FDrawing := False;
      end;
    end;
     
    procedure TSpriteButton.SetTransparent(const Value: Boolean);
    begin
      if Value <> FTransparent then
      begin
        FTransparent := Value;
        if not FDrawing then Invalidate;
      end;
    end;
     
    end.
