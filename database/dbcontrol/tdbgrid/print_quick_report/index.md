---
Title: Печать содержимого TDBGrid через Quick Report
Author: Rafael Ribas Aguilу
Date: 01.01.2007
---


Печать содержимого TDBGrid через Quick Report
=============================================

::: {.date}
01.01.2007
:::

Автор: Rafael Ribas Aguilу

Частенько у пользователя возникает необходимость распечатать отчёт из
базы данных. Естественно, что он начинает просить Вас добавить такую
возможность в приложение. Как оказалось, при помощи TQuickRep данную
задачу можно очень легко решить.

Итак, приступим. Для начала создайте новую форму, назвав её TGridReport,
и поместите на неё TQuickRep. Переименуйте QuickRep в GridRep. Затем
сделайте следующию процедуру, которая получает в качестве параметра
DBGrid:

    procedure TGridReport.Preview(Grid: TDBGrid); 
    var 
      i, CurrentLeft, CurrentTop : integer; 
      BMark: TBookmark; 
    begin 
      GridRep.Dataset:=Grid.DataSource.DataSet; 
     
      if not GridRep.Bands.HasColumnHeader then 
        GridRep.Bands.HasColumnHeader:=true; 
     
      if not GridRep.Bands.HasDetail then 
        GridRep.Bands.HasDetail:=true; 
     
      GridRep.Bands.ColumnHeaderBand.Height:=Abs(Grid.TitleFont.Height) + 10; 
      GridRep.Bands.DetailBand.Height:=Abs(Grid.Font.Height) + 10; 
      CurrentLeft := 12; 
      CurrentTop := 6; 
     
      {Запись, на которой пользователь останавливается в DBGrid} 
      BMark:=Grid.DataSource.DataSet.GetBookmark; 
      {Запретим мерцание грида в процессе работы отчёта} 
      Grid.DataSource.DataSet.DisableControls; 
      try 
        for i:=0 to Grid.FieldCount - 1 do 
        begin 
          if (CurrentLeft + Canvas.TextWidth(Grid.Columns[i].Title.Caption)) > 
            (GridRep.Bands.ColumnHeaderBand.Width) then 
          begin 
            CurrentLeft := 12; 
            CurrentTop := CurrentTop + Canvas.TextHeight('A') + 6; 
            GridRep.Bands.ColumnHeaderBand.Height := GridRep.Bands.ColumnHeaderBand.Height + 
              (Canvas.TextHeight('A') + 10); 
            GridRep.Bands.DetailBand.Height := GridRep.Bands.DetailBand.Height + 
              (Canvas.TextHeight('A') + 10); 
          end; 
          {Создадим заголовок отчёта при помощи QRLabels} 
          with TQRLabel.Create(GridRep.Bands.ColumnHeaderBand) do 
          begin 
            Parent := GridRep.Bands.ColumnHeaderBand; 
            Color := GridRep.Bands.ColumnHeaderBand.Color; 
            Left := CurrentLeft; 
            Top := CurrentTop; 
            Caption:=Grid.Columns[i].Title.Caption; 
          end; 
          {Создадим тело отчёта при помощи QRDBText} 
          with TQRDbText.Create(GridRep.Bands.DetailBand) do 
          begin 
            Parent := GridRep.Bands.DetailBand; 
            Color := GridRep.Bands.DetailBand.Color; 
            Left := CurrentLeft; 
            Top := CurrentTop; 
            Alignment:=Grid.Columns[i].Alignment; 
            AutoSize:=false; 
            AutoStretch:=true; 
            Width:=Grid.Columns[i].Width; 
            Dataset:=GridRep.Dataset; 
            DataField:=Grid.Fields[i].FieldName; 
            CurrentLeft:=CurrentLeft + (Grid.Columns[i].Width) + 15; 
          end; 
        end; 
     
        lblPage.Left := bdTitle.Width - lblPage.Width - 10; 
        lblDate.Left := bdTitle.Width - lblDate.Width - 10; 
     
        {Далее вызовем метод предварительного просмотра из QuickRep} 
        GridRep.PreviewModal; {либо, если желаете, то PreviewModal} 
     
      finally 
        with Grid.DataSource.DataSet do 
        begin 
          GotoBookmark(BMark); 
          FreeBookmark(BMark); 
          EnableControls; 
        end; 
      end; 
    end; 

Взято из <https://forum.sources.ru>
