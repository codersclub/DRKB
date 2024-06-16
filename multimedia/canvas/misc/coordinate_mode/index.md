---
Title: Изменить режим координат
Author: Xavier Pacheco and Steve Teixeira
Date: 01.01.2000
---


Изменить режим координат
========================

    {
    Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
     
    unit MainFrm;
     
    interface
     
    uses
      SysUtils, Windows, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, Menus, DB, DBCGrids, DBTables;
     
    type
      TMainForm = class(TForm)
        mmMain: TMainMenu;
        mmiMappingMode: TMenuItem;
        mmiMM_ISOTROPIC: TMenuItem;
        mmiMM_ANSITROPIC: TMenuItem;
        mmiMM_LOENGLISH: TMenuItem;
        mmiMM_HIINGLISH: TMenuItem;
        mmiMM_LOMETRIC: TMenuItem;
        mmiMM_HIMETRIC: TMenuItem;
        procedure FormCreate(Sender: TObject);
        procedure mmiMM_ISOTROPICClick(Sender: TObject);
        procedure mmiMM_ANSITROPICClick(Sender: TObject);
        procedure mmiMM_LOENGLISHClick(Sender: TObject);
        procedure mmiMM_HIINGLISHClick(Sender: TObject);
        procedure mmiMM_LOMETRICClick(Sender: TObject);
        procedure mmiMM_HIMETRICClick(Sender: TObject);
      public
        MappingMode: Integer;
        procedure ClearCanvas;
        procedure DrawMapMode(Sender: TObject);
      end;
     
    var
      MainForm: TMainForm;
     
    implementation
     
    {$R *.DFM}
     
    procedure TMainForm.ClearCanvas;
    begin
      with Canvas do
      begin
        Brush.Style := bsSolid;
        Brush.Color := clWhite;
        FillRect(ClipRect);
      end;
    end;
     
    procedure TMainForm.DrawMapMode(Sender: TObject);
    var
      PrevMapMode: Integer;
    begin
      ClearCanvas;
      Canvas.TextOut(0, 0, (Sender as TMenuItem).Caption);
     
      // Set mapping mode to MM_LOENGLISH and save the previous mapping mode
      PrevMapMode := SetMapMode(Canvas.Handle, MappingMode);
      try
        // Set the viewport org to left, bottom
        SetViewPortOrgEx(Canvas.Handle, 0, ClientHeight, nil);
        { Draw some shapes to illustrate drawing shapes with different
          mapping modes specified by MappingMode }
        Canvas.Rectangle(0, 0, 200, 200);
        Canvas.Rectangle(200, 200, 400, 400);
        Canvas.Ellipse(200, 200, 400, 400);
        Canvas.MoveTo(0, 0);
        Canvas.LineTo(400, 400);
        Canvas.MoveTo(0, 200);
        Canvas.LineTo(200, 0);
      finally
        // Restore previous mapping mode
        SetMapMode(Canvas.Handle, PrevMapMode);
      end;
    end;
     
    procedure TMainForm.FormCreate(Sender: TObject);
    begin
      MappingMode := MM_TEXT;
    end;
     
    procedure TMainForm.mmiMM_ISOTROPICClick(Sender: TObject);
    var
      PrevMapMode: Integer;
    begin
      ClearCanvas;
      // Set mapping mode to MM_ISOTROPIC and save the previous mapping mode
      PrevMapMode := SetMapMode(Canvas.Handle, MM_ISOTROPIC);
      try
        // Set the window extent to 500 x 500
        SetWindowExtEx(Canvas.Handle, 500, 500, nil);
        // Set the Viewport extent to the Window's client area
        SetViewportExtEx(Canvas.Handle, ClientWidth, ClientHeight, nil);
        // Set the ViewPortOrg to the center of the client area
        SetViewportOrgEx(Canvas.Handle, ClientWidth div 2, ClientHeight div 2, nil);
        // Draw a rectangle based on current settings
        Canvas.Rectangle(0, 0, 250, 250);
        { Set the viewport extent to a different value, and
          draw another rectangle. continue to do this three
          more times so that a rectangle is draw to represent
          the plane in a four-quadrant square }
        SetViewportExtEx(Canvas.Handle, ClientWidth, -ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
     
        SetViewportExtEx(Canvas.Handle, -ClientWidth, -ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
     
        SetViewportExtEx(Canvas.Handle, -ClientWidth, ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
        // Draw an ellipse in the center of the client area
        Canvas.Ellipse(-50, -50, 50, 50);
      finally
        // Restore the previous mapping mode
        SetMapMode(Canvas.Handle, PrevMapMode);
      end;
    end;
     
    procedure TMainForm.mmiMM_ANSITROPICClick(Sender: TObject);
    var
      PrevMapMode: Integer;
    begin
      ClearCanvas;
      // Set the mapping mode to MM_ANISOTROPIC and save the previous mapping mode
      PrevMapMode := SetMapMode(Canvas.Handle, MM_ANISOTROPIC);
      try
        // Set the window extent to 500 x 500
        SetWindowExtEx(Canvas.Handle, 500, 500, nil);
        // Set the Viewport extent to that of the Window's client area
        SetViewportExtEx(Canvas.Handle, ClientWidth, ClientHeight, nil);
        // Set the ViewPortOrg to the center of the client area
        SetViewportOrgEx(Canvas.Handle, ClientWidth div 2, ClientHeight div 2, nil);
        // Draw a rectangle based on current settings
        Canvas.Rectangle(0, 0, 250, 250);
        { Set the viewport extent to a different value, and
          draw another rectangle. continue to do this three
          more times so that a rectangle is draw to represent
          the plane in a four-quadrant square }
        SetViewportExtEx(Canvas.Handle, ClientWidth, -ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
     
        SetViewportExtEx(Canvas.Handle, -ClientWidth, -ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
     
        SetViewportExtEx(Canvas.Handle, -ClientWidth, ClientHeight, nil);
        Canvas.Rectangle(0, 0, 250, 250);
        // Draw an ellipse in the center of the client area
        Canvas.Ellipse(-50, -50, 50, 50);
      finally
        //Restore the previous mapping mode
        SetMapMode(Canvas.Handle, PrevMapMode);
      end;
    end;
     
    procedure TMainForm.mmiMM_LOENGLISHClick(Sender: TObject);
    begin
      MappingMode := MM_LOENGLISH;
      DrawMapMode(Sender);
    end;
     
    procedure TMainForm.mmiMM_HIINGLISHClick(Sender: TObject);
    begin
      MappingMode := MM_HIENGLISH;
      DrawMapMode(Sender);
    end;
     
    procedure TMainForm.mmiMM_LOMETRICClick(Sender: TObject);
    begin
      MappingMode := MM_LOMETRIC;
      DrawMapMode(Sender);
    end;
     
    procedure TMainForm.mmiMM_HIMETRICClick(Sender: TObject);
    begin
      MappingMode := MM_HIMETRIC;
      DrawMapMode(Sender);
    end;
     
    end.
