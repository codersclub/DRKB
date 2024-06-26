---
Title: Приложение для просмотра изображений JPEG и BMP
Date: 01.01.2007
---


Приложение для просмотра изображений JPEG и BMP
===============================================

    unit mainUnit;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtDlgs, StdCtrls, ComCtrls, ExtCtrls, Buttons, ToolWin, ImgList;
     
    type
      TForm1 = class(TForm)
        SavePictureDialog1: TSavePictureDialog;
        OpenPictureDialog1: TOpenPictureDialog;
        ScrollBox1: TScrollBox;
        Image1: TImage;
        ToolBar1: TToolBar;
        OpenBtn: TToolButton;
        SaveBtn: TToolButton;
        Panel2: TPanel;
        ProgressBar1: TProgressBar;
        ImageList1: TImageList;
        procedure SavePictureDialog1TypeChange(Sender: TObject);
        procedure Image1Progress(Sender: TObject; Stage: TProgressStage;
          PercentDone: Byte; RedrawNow: Boolean; const R: TRect;
          const Msg: string);
        procedure SavePictureDialog1Close(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure OpenBitBtnClick(Sender: TObject);
        procedure SaveBitBtnClick(Sender: TObject);
        procedure ToolBar1Resize(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
    uses jpeg;
    const DeltaH: Integer = 80;
    var Quality: TJpegQualityRange;
      ProgressiveEnc: Boolean;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var s: string;
    begin
      s := GraphicFilter(TBitmap) + '|' + GraphicFilter(TJpegImage);
      OpenPictureDialog1.Filter := s;
      SavePictureDialog1.Filter := s;
    end;
     
    procedure TForm1.OpenBitBtnClick(Sender: TObject);
    begin
      if OpenPictureDialog1.Execute
        then
      begin
        Image1.Picture.LoadFromFile(OpenPictureDialog1.FileName);
        SaveBtn.Enabled := True;
      end;
    end;
     
    procedure TForm1.SaveBitBtnClick(Sender: TObject);
    var ji: TJpegImage;
    begin
      with SavePictureDialog1 do
      begin
        FilterIndex := 1;
        FileName := '';
        if not Execute then Exit;
     
        if Pos('.', FileName) = 0 then
          if (FilterIndex = 1) then
            FileName := FileName + '.bmp'
          else
            FileName := FileName + '.jpg';
     
        if (FilterIndex = 1) then
          Image1.Picture.Bitmap.SaveToFile(FileName)
        else
        begin
          ji := TJpegImage.Create;
          ji.CompressionQuality := Quality;
          ji.ProgressiveEncoding := ProgressiveEnc;
          ji.OnProgress := Image1Progress;
          ji.Assign(Image1.Picture.Bitmap);
          ji.SaveToFile(FileName);
          ji.Free;
        end;
      end;
     
    end;
     
    procedure TForm1.SavePictureDialog1TypeChange(Sender: TObject);
    var ParentHandle: THandle; wRect: TRect;
      PicPanel, PaintPanel: TPanel; QEdit: TEdit;
    begin
      with Sender as TSavePictureDialog do
      begin
        //родительская панель
        PicPanel := (FindComponent('PicturePanel') as TPanel);
        if not Assigned(PicPanel) then Exit;
        ParentHandle := GetParent(Handle);
     
        //панель-сосед сверху
        PaintPanel := (FindComponent('PaintPanel') as TPanel);
        PaintPanel.Align := alNone;
        if FilterIndex > 1 then
        begin
          GetWindowRect(ParentHandle, WRect);
          SetWindowPos(ParentHandle, 0, 0, 0, WRect.Right - WRect.Left,
            WRect.Bottom - WRect.Top + DeltaH, SWP_NOMOVE + SWP_NOZORDER);
          GetWindowRect(Handle, WRect);
          SetWindowPos(handle, 0, 0, 0, WRect.Right - WRect.Left,
            WRect.Bottom - WRect.Top + DeltaH, SWP_NOMOVE + SWP_NOZORDER);
          PicPanel.Height := PicPanel.Height + DeltaH;
     
          if FindComponent('JLabel') = nil then
            with TLabel.Create(Sender as TSavePictureDialog) do
            begin
              Parent := PicPanel;
              Name := 'JLabel';
              Caption := 'Quality';
              Left := 5; //Width := PicPanel.Width - 10;
              Height := 25;
              Top := PaintPanel.Top + PaintPanel.Height + 5;
            end;
     
          if FindComponent('JEdit') = nil then
          begin
            QEdit := TEdit.Create(Sender as TSavePictureDialog);
            with QEdit do
            begin
              Parent := PicPanel;
              Name := 'JEdit';
              Text := '75';
              Left := 50; Width := 50;
              Height := 25;
              Top := PaintPanel.Top + PaintPanel.Height + 5;
            end;
          end;
     
          if FindComponent('JUpDown') = nil then
            with TUpDown.Create(Sender as TSavePictureDialog) do
            begin
              Parent := PicPanel;
              Name := 'JUpDown';
              Associate := QEdit;
              Increment := 5;
              Min := 1; Max := 100;
              Position := 75;
            end;
     
          if FindComponent('JCheck') = nil then
            with TCheckBox.Create(Sender as TSavePictureDialog) do
            begin
              Name := 'JCheck';
              Caption := 'Progressive Encoding';
              Parent := PicPanel;
              Left := 5; Width := PicPanel.Width - 10;
              Height := 25;
              Top := PaintPanel.Top + PaintPanel.Height + 35;
            end;
        end
        else
          SavePictureDialog1Close(Sender);
      end;
    end;
     
    procedure TForm1.Image1Progress(Sender: TObject; Stage: TProgressStage;
      PercentDone: Byte; RedrawNow: Boolean; const R: TRect;
      const Msg: string);
    begin
      case Stage of
        psStarting: begin
            Progressbar1.Position := 0;
            Progressbar1.Max := 100;
          end;
        psEnding: begin
            Progressbar1.Position := 0;
          end;
        psRunning: begin
            Progressbar1.Position := PercentDone;
          end;
      end;
    end;
     
    procedure TForm1.SavePictureDialog1Close(Sender: TObject);
    var PicPanel: TPanel; ParentHandle: THandle; WRect: TRect;
    begin
     
      with Sender as TSavePictureDialog do
      begin
        PicPanel := (FindComponent('PicturePanel') as TPanel);
        if not Assigned(PicPanel) then Exit;
        ParentHandle := GetParent(Handle);
        if ParentHandle = 0 then Exit;
        if FindComponent('JLabel') <> nil then
        try
          FindComponent('JLabel').Free;
          FindComponent('JEdit').Free;
          ProgressiveEnc := (FindComponent('JCheck') as TCheckBox).Checked;
          FindComponent('JCheck').Free;
          Quality := (FindComponent('JUpDown') as TUpDown).Position;
          FindComponent('JUpDown').Free;
     
          PicPanel.Height := PicPanel.Height - DeltaH;
          GetWindowRect(Handle, WRect);
          SetWindowPos(Handle, 0, 0, 0, WRect.Right - WRect.Left,
            WRect.Bottom - WRect.Top - DeltaH, SWP_NOMOVE + SWP_NOZORDER);
          GetWindowRect(ParentHandle, WRect);
          SetWindowPos(ParentHandle, 0, 0, 0, WRect.Right - WRect.Left,
            WRect.Bottom - WRect.Top - DeltaH, SWP_NOMOVE + SWP_NOZORDER);
          FilterIndex := 1;
        except
          ShowMessage('Dialog resizing error');
        end;
      end;
    end;
     
    procedure TForm1.ToolBar1Resize(Sender: TObject);
    begin
      Panel2.Width := ToolBar1.Width - Panel2.Left;
    end;
     
    end.
