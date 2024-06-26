---
Title: Экспортировать TDBGrid в HTML
Date: 01.01.2007
---


Экспортировать TDBGrid в HTML
=============================

    type
     TGridToHTMLOption = (ghWithHeaders);
     TGridToHTMLOptions = set of TGridToHTMLOption;
     
    function DBGridToHTML(Grid : TDBGrid;
      ExportOptions: TGridToHTMLOptions): String;
    const
      HTMLStart =
       '<!DOCTYPE HTML PUBLIC " -//W3C//DTD HTML 4.0 Transitional//EN">'#13 +
       '<HTML>'#13 +
       '<HEAD> <META http-equiv=Content-Type content=" text/html; charset=windows-1251">'#13 +
       '<STYLE>'#13 +
       'BODY {'#13 +
       ' BACKGROUND: white;'#13 +
       ' COLOR: black;'#13 +
       ' FONT-FAMILY: arial;'#13 +
       ' FONT-SIZE: 8pt;'#13 +
       ' VERTICAL-ALIGN: top'#13 +
       '}'#13 +
       'TABLE {'#13 +
       ' BACKGROUND: white;'#13 +
       ' BORDER-BOTTOM: silver 0px solid;'#13 +
       ' BORDER-LEFT: silver 1px solid;'#13 +
       ' BORDER-RIGHT: silver 0px solid;'#13 +
       ' BORDER-TOP: silver 1px solid;'#13 +
       ' FONT-FAMILY: arial;'#13 +
       ' FONT-SIZE: 8pt;'#13 +
       ' FONT-WEIGHT: normal;'#13 +
       '}'#13 +
       'TD {'#13 +
       ' BORDER-BOTTOM: silver 1px solid;'#13 +
       ' BORDER-LEFT: silver 0px solid;'#13 +
       ' BORDER-RIGHT: silver 1px solid;'#13 +
       ' BORDER-TOP: silver 0px solid;'#13 +
       ' VERTICAL-ALIGN: top;'#13 +
       ' TEXT-ALIGN: left;'#13 +
       '}'#13 +
       'TD.grid {'#13 +
       ' TEXT-ALIGN: left;'#13 +
       '}'#13 +
       'TD.gridr {'#13 +
       ' TEXT-ALIGN: right;'#13 +
       '}'#13 +
       'TD.gridc {'#13 +
       ' TEXT-ALIGN: center;'#13 +
       '}'#13 +
       'TH {'#13 +
       ' BACKGROUND: silver;'#13 +
       ' BORDER-BOTTOM: gray 1px solid;'#13 +
       ' BORDER-LEFT: gray 0px solid;'#13 +
       ' BORDER-RIGHT: gray 1px solid;'#13 +
       ' BORDER-TOP: gray 0px solid;'#13 +
       ' FONT-WEIGHT: bold;'#13 +
       '}'#13 +
       'TH.grid {'#13 +
       ' TEXT-ALIGN: left;'#13 +
       '}'#13 +
       'TH.gridr {'#13 +
       ' TEXT-ALIGN: right;'#13 +
       '}'#13 +
       'TH.gridc {'#13 +
       ' TEXT-ALIGN: center;'#13 +
       '}'#13 +
       '</STYLE>'#13 +
       '<TITLE>Печать таблицы</TITLE>'#13 +
       '</HEAD>'#13 +
       '<BODY>'#13;
      HTMLEnd = '</BODY></HTML>';
      TableStart = '<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=1>'#13;
      TableEnd = '</TABLE>'#13;
      HeaderRowStart = '<TR>'#13;
      HeaderRowEnd = '</TR>'#13;
      BodyRowStart = '<TR>'#13;
      BodyRowEnd = '</TR>'#13;
     
    const
      StyleNames: array [TAlignment] of String = ('grid', 'gridr', 'gridc');
     
      function TD(Column: TColumn; IsTitle: Boolean; Widht: Integer):
    String;
      var
        S: String;
        Align: TAlignment;
        Tag: String;
      begin
        if IsTitle then begin
          Tag := 'TH';
          Align := Column.Title.Alignment;
          S := StyleNames[Align];
        end else begin
          Tag := 'TD';
          Align := Column.Alignment;
          if Align = taLeftJustify then begin
            if (Column.Field is TBCDField) or
               (Column.Field is TCurrencyField) then
              Align := taRightJustify;
            if (Column.Field is TBooleanField) then
              Align := taCenter;
          end;
          S := StyleNames[Align];
          if (Column.Field is TBCDField) or (Column.Field is TIntegerField) then
            S := S + ' NOWRAP'
        end;
        if Widht >  0 then
          S := S + Format(' WIDTH=" %d%%" ', [Widht]);
        Result := '<' + Tag + ' class=' + S + '>';
        if IsTitle then begin
          S := Column.Title.Caption
        end else begin
          if Column.Field is TBooleanField then
          with TBooleanField(Column.Field) do begin
            if Length(DisplayValues) = 0 then begin
              if AsBoolean then
                S := 'да'
              else
                S := 'нет';
            end else
              S := Column.Field.DisplayText;
          end else
            S := Column.Field.DisplayText;
        end;
        if Length(Trim(S)) = 0 then
          S := ' ';
        Result := Result + S + '</' + Tag + '>'#13;
      end;
     
    var
     BM : String;
     I : Integer;
     Widhts: array of Integer;
     TotalWidht: Integer;
    begin
      Result := '';
      with Grid  do begin
        if Assigned(DataSource) and
           Assigned(DataSource.DataSet) and
           DataSource.DataSet.Active then
        with DataSource.DataSet do begin
          DisableControls;
          BM := BookMark;
          SetLength(Widhts, Columns.Count);
          TotalWidht := 0;
          for I := 0 to Pred(Columns.Count) do begin
            if Assigned(Columns[I].Field) then begin
              Widhts[I] := Columns[I].Width;
              Inc(TotalWidht, Widhts[I]);
            end;
          end;
          for I := 0 to High(Widhts) do begin
            Widhts[I] := Widhts[I] * 100 div TotalWidht;
          end;
          Result := HTMLStart;
          Result := Result + TableStart;
          if (ghWithHeaders in ExportOptions) then begin
            Result := Result + HeaderRowStart;
            for I := 0 to Pred(Columns.Count) do begin
              if Assigned(Columns.Items[I].Field) then begin
                Result := Result + TD(Columns.Items[I], TRUE, Widhts[I]);
              end;
            end;
            Result := Result + HeaderRowEnd;
          end;
          First;
          while not Eof do begin
            Result := Result + BodyRowStart;
            for I := 0 to Pred( Columns.Count ) do begin
              if Assigned(Columns.Items[I].Field) then begin
                Result := Result + TD(Columns.Items[I], FALSE, -1{Integer(Widhts[Index]});
              end;
            end;
            Result := Result + BodyRowEnd;
            Next;
          end;
          Result := Result + TableEnd + HTMLEnd;
          BookMark := BM;
          EnableControls;
        end;
      end;
    end;
