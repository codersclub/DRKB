---
Title: Сохранение и загрузка коллекций
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Сохранение и загрузка коллекций
===============================

    unit DelphiPt;
     
    interface
     
    uses
      Classes, Graphics;
     
    type
      TDDHPoint = class (TCollectionItem)
      private
        fX, fY: Integer;
      public
        Text: string;
        procedure WriteText (Writer: TWriter);
        procedure ReadText (Reader: TReader);
        procedure DefineProperties (Filer: TFiler); override;
        procedure Paint (Canvas: TCanvas);
        procedure Assign (Pt: TPersistent); override;
      published
        property X: Integer read fX write fX;
        property Y: Integer read fY write fY;
      end;
     
      TWrapper = class (TComponent)
      private
        FColl: TCollection;
      published
        property MyColl: TCollection read FColl write FColl;
      public
        constructor Create (Owner: TComponent); override;
        destructor Destroy; override;
      end;
     
    implementation
     
    // TWrapper constructor and destructor
     
    constructor TWrapper.Create (Owner: TComponent);
    begin
      inherited Create (Owner);
      FColl := TCollection.Create (TDDHPoint);
    end;
     
    destructor TWrapper.Destroy;
    begin
      FColl.Clear;
      FColl.Free;
      inherited Destroy;
    end;
     
     
    // class TDDHPoint methods
     
    procedure TDDHPoint.WriteText (Writer: TWriter);
    begin
      Writer.WriteString (Text);
    end;
     
    procedure TDDHPoint.ReadText (Reader: TReader);
    begin
      Text := Reader.ReadString;
    end;
     
    procedure TDDHPoint.DefineProperties (Filer: TFiler);
    begin
      Filer.DefineProperty (
        'Text', ReadText, WriteText, (Text <> ''));
    end;
     
    procedure TDDHPoint.Paint (Canvas: TCanvas);
    begin
      Canvas.Ellipse (fX - 3, fY - 3, fX + 3, fY + 3);
      Canvas.TextOut (fX + 5, fY + 5, Text);
    end;
     
    procedure TDDHPoint.Assign (Pt: TPersistent);
    begin
      if Pt is TDDHPoint then
      begin
        fx := TDDHPoint (Pt).fX;
        fY := TDDHPoint (Pt).fY;
        Text := TDDHPoint (Pt).Text;
      end
      else
        // raise an exception
        inherited Assign (pt);
    end;
     
    //initialization
    //RegisterClass (TWrapper);
    end.

    unit PersForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Buttons, StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Panel1: TPanel;
        Label1: TLabel;
        Edit1: TEdit;
        SpeedButtonLoad: TSpeedButton;
        SpeedButtonSave: TSpeedButton;
        OpenDialog1: TOpenDialog;
        SaveDialog1: TSaveDialog;
        procedure FormCreate(Sender: TObject);
        procedure SpeedButtonSaveClick(Sender: TObject);
        procedure SpeedButtonLoadClick(Sender: TObject);
        procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure FormDestroy(Sender: TObject);
        procedure FormPaint(Sender: TObject);
      private
        PtList: TCollection;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses
      DelphiPt;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      PtList := TCollection.Create (TDDHPoint);
    end;
     
    procedure TForm1.SpeedButtonSaveClick(Sender: TObject);
    var
      Str1: TFileStream;
      Wrap: TWrapper;
    begin
      if SaveDialog1.Execute then
      begin
        Str1 := TFileStream.Create (SaveDialog1.FileName,
          fmOpenWrite or fmCreate);
        try
          Wrap := TWrapper.Create (self);
          try
            Wrap.MyColl.Assign (ptList);
            Str1.WriteComponent (Wrap);
          finally
            Wrap.Free;
          end;
        finally
          Str1.Free;
        end;
      end;
    end;
     
    procedure TForm1.SpeedButtonLoadClick(Sender: TObject);
    var
      Str1: TFileStream;
      Wrap: TWrapper;
    begin
      if OpenDialog1.Execute then
      begin
        Str1 := TFileStream.Create (
          OpenDialog1.Filename, fmOpenRead);
        try
          Wrap := TWrapper.Create (self);
          try
            Wrap := Str1.ReadComponent (Wrap) as TWrapper;
            ptList.Assign (Wrap.MyColl);
          finally
            Wrap.Free;
          end;
        finally
          Str1.Free;
          Invalidate;
          Edit1.Text := 'Point ' + IntToStr (PtList.Count + 1);
        end;
      end;
    end;
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    var
      Pt: TDDHPoint;
    begin
      Pt := PtList.Add as TDDHPoint;
      Pt.X := X;
      Pt.Y := Y;
      Pt.Text := Edit1.Text;
      Edit1.Text := 'Point ' + IntToStr (PtList.Count + 1);
      Invalidate;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      // empty and destroy the list
      PtList.Clear;
      PtList.Free;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    var
      I: Integer;
    begin
      for I := 0 to PtList.Count - 1 do
        TDDHPoint (PtList.Items [I]).Paint (Canvas);
    end;
     
    end.

