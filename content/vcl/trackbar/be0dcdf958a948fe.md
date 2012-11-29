Как бы мне создать эдакий TTrackBar, в котором вместо широкой белой полоски с ползунком была бы тонкая линия?
=============================================================================================================

::: {.date}
01.01.2007
:::

В примере создается компонент, унаследованный от TTrackbar который
переопределяет метод CreateParams и убират флаг TBS\_ENABLESELRANGE из
Style. Константа TBS\_ENABLESELRANGE обьявленна в модуле CommCtrl.

    uses CommCtrl, ComCtrls;
     
    type
      TMyTrackBar = class(TTrackBar)
        procedure CreateParams(var Params: TCreateParams); override;
      end;
     
    procedure TMyTrackBar.CreateParams(var Params: TCreateParams);
    begin
      inherited;
      Params.Style := Params.Style and not TBS_ENABLESELRANGE;
    end;
     
    var
      MyTrackbar: TMyTrackbar;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      MyTrackBar := TMyTrackbar.Create(Form1);
      MyTrackbar.Parent := Form1;
      MyTrackbar.Left := 100;
      MyTrackbar.Top := 100;
      MyTrackbar.Width := 150;
      MyTrackbar.Height := 45;
      MyTrackBar.Visible := true;
    end;
