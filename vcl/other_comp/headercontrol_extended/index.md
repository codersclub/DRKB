---
Title: HeaderControl с дополнительной возможностью отображения стрелок
Author: Rouse\_
Date: 01.01.2007
---


HeaderControl с дополнительной возможностью отображения стрелок
===============================================================

::: {.date}
01.01.2007
:::

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Unit Name : GSHeaderControl
    //  * Purpose   : Обычный HeaderControl с дополнительной возможностью отображения стрелок
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //

    unit GSHeaderControl;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Controls, ComCtrls, CommCtrl, Themes,
      Graphics;
     
    const
      HDF_SORTDOWN = $0200;
      HDF_SORTUP = $0400;
     
    type
      TGSSortDirection = (sdUp, sdDown);
      TGSHeaderControl = class(THeaderControl)
      private
        FSortSection: Integer;
        FSortDirection: TGSSortDirection;
        FUpDownBitmap: array [sdUp..sdDown] of TBitmap;
        procedure WMLButtonDown(var Message: TWMLButtonDown); message WM_LBUTTONDOWN;
        procedure SetSortDirection(const Value: TGSSortDirection);
        procedure SetSortSection(const Value: Integer);
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        // Отрисовка стрелок через эти 2 свойства
        // Секция в которой будем рисовать стрелку (для отключения стрелок, SortedSection := -1)
        property SortedSection: Integer read FSortSection write SetSortSection;
        // Направление стрелки (вверх - вниз)
        property SortDirection: TGSSortDirection read FSortDirection write SetSortDirection;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Samlpes', [TGSHeaderControl]);
    end;
     
    { TGSHeaderControl }
     
    constructor TGSHeaderControl.Create(AOwner: TComponent);
    var
      I: TGSSortDirection;
    begin
      inherited;
      FSortSection := -1;
      FSortDirection := sdDown;
      for I := sdUp to sdDown do
      begin
        FUpDownBitmap[I] := TBitmap.Create;
        FUpDownBitmap[I].Width := 14;
        FUpDownBitmap[I].Height := 14;
        FUpDownBitmap[I].Canvas.Brush.Color := clBtnFace;
        FUpDownBitmap[I].Canvas.Fillrect(Rect(0, 0, 14, 14));
        FUpDownBitmap[I].Canvas.Font.Size := 14;
        FUpDownBitmap[I].Canvas.Font.Name := 'Marlett';
      end;
      // Эти битматы для рисования стрелки при отключенных темах ХР
      FUpDownBitmap[sdUp].Canvas.TextOut(0, -2, #53);
      FUpDownBitmap[sdDown].Canvas.TextOut(0, -2, #54);
    end;
     
    destructor TGSHeaderControl.Destroy;
    begin
      FUpDownBitmap[sdUp].Free;
      FUpDownBitmap[sdDown].Free;
      inherited;
    end;
     
    // Указываем направление стрелки (вверх - вниз)
    procedure TGSHeaderControl.SetSortDirection(const Value: TGSSortDirection);
    begin
      FSortDirection := Value;
      SetSortSection(FSortSection);
    end;
     
    // Включаем стили для отрисовки стрелок
    procedure TGSHeaderControl.SetSortSection(const Value: Integer);
    var
      Item: THDItem;
      PreviosSelected: Integer;
      Direction: Integer;
    begin
      PreviosSelected := FSortSection;
      FSortSection := Value;
      if Sections.Count = 0 then Exit;
      if Value >= Sections.Count then Exit;
      // При включенных темах будем рисовать вот так:
      if ThemeServices.ThemesEnabled then
      begin
        if FSortDirection = sdUp then
          Direction := HDF_SORTUP
        else
          Direction := HDF_SORTDOWN;
        Item.Mask := HDI_FORMAT;
        // Убираем предыдущую стрелку
        if Header_GetItem(Handle, PreviosSelected, Item) then
          if (Item.fmt and HDF_SORTUP) = HDF_SORTUP then
          begin
            Item.fmt := Item.fmt xor HDF_SORTUP;
            Header_SetItem(Handle, PreviosSelected, Item);
          end;
          if (Item.fmt and HDF_SORTDOWN) = HDF_SORTDOWN then
          begin
            Item.fmt := Item.fmt xor HDF_SORTDOWN;
            Header_SetItem(Handle, PreviosSelected, Item);
          end;
        // Рисуем новую
        Item.Mask := HDI_FORMAT;
        Header_GetItem(Handle, FSortSection, Item);
        Item.fmt := Item.fmt or Direction;
        Header_SetItem(Handle, FSortSection, Item);
      end
      else
      begin // При выключенных темах, рисуем вот так:
        // Убираем предыдущую стрелку
        Item.Mask := HDI_FORMAT or HDI_BITMAP;
        Header_GetItem(Handle, PreviosSelected, Item);
        if (Item.fmt and HDF_BITMAP_ON_RIGHT) = HDF_BITMAP_ON_RIGHT then
          Item.fmt := Item.fmt xor HDF_BITMAP_ON_RIGHT;
        if (Item.fmt and HDF_BITMAP) = HDF_BITMAP then
          Item.fmt := Item.fmt xor HDF_BITMAP;
        Header_SetItem(Handle, PreviosSelected, Item);
        // Рисуем новую
        Item.Mask := HDI_FORMAT or HDI_BITMAP;
        Header_GetItem(Handle, FSortSection, Item);
        if (Item.fmt and HDF_BITMAP_ON_RIGHT) = HDF_BITMAP_ON_RIGHT then
          Item.fmt := Item.fmt xor HDF_BITMAP_ON_RIGHT;
        if (Item.fmt and HDF_BITMAP) = HDF_BITMAP then
          Item.fmt := Item.fmt xor HDF_BITMAP;
        Item.fmt := Item.fmt or HDF_BITMAP_ON_RIGHT or HDF_BITMAP;
        Item.hbm := FUpDownBitmap[FSortDirection].Handle;
        Header_SetItem(Handle, FSortSection, Item);
      end;
    end;
     
    // Включаем обработчик OnSectionClick при стиле hsFlat
    procedure TGSHeaderControl.WMLButtonDown(var Message: TWMLButtonDown);
    var
      Index: Integer;
      Info: THDHitTestInfo;
    begin
      Info.Point.X := Message.Pos.X;
      Info.Point.Y := Message.Pos.Y;
      Index := SendMessage(Handle, HDM_HITTEST, 0, Integer(@Info));
     
      if (Index < 0) or (Info.Flags and HHT_ONHEADER = 0) or
        Sections[Index].AllowClick then
      begin
        inherited;
        if Style = hsFlat then
          if Index in [0 .. Sections.Count - 1] then
            Self.OnSectionClick(Self, Sections[Index]);
      end;
    end;
     
     
    end.

Взято из <https://forum.sources.ru>

Автор: Rouse\_
