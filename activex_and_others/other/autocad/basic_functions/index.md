---
Title: Базовые функции по работе с Автокадовскими скриптами
Date: 03.06.2002
author: softland, softland@zmail.ru
---


Базовые функции по работе с Автокадовскими скриптами
====================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Базовые функции по работе с Автокадовскими скриптами, вывод основных примитивов.
     
    Назначение модуля
    Модуль предназначен для создания файлов скриптов выполняемых программой AutoCAD
    Созданные скрипты аналогичны командам выполняемым в командной строке AutoCAD
     
    Зависимости: SysUtils, Types
    Автор:       softland, softland@zmail.ru, Волгоград
    Copyright:   softland@zmail.ru
    Дата:        3 июня 2002 г.
    ********************************************** }
     
    {
    @abstract(provides methods to operate on AutoCAD scripts)
    @author(Vitaly Sergienko (softland@zmail.ru))
    @created(29 Oct 2001)
    @lastmod(3 Jun 2002)
     
    Review
    Perform basic methods to operate on AutoCAD scripts: line, circle, hatch, ...
    Обеспечивает базовые функции по работе с Автокадовскими скриптами, вывод основных примитивов.
     
    Назначение модуля
      Модуль предназначен для создания файлов скриптов выполняемых программой AutoCAD
      Созданные скрипты аналогичны командам выполняемым в командной строке AutoCAD и
      могут содержать следующие операции:
       * pline - многосегментная линия
       * line - линия
       * rectangle - прямоугольник
       * -mtext - многострочный текст
       * text - однострочный текст
       * -layer - слой
       * -color - цвет
       * -style - стиль текста
       * insert - вставка блока
     
    Как можно применить
      Пусть у Вас имеется база данных по объектам, у меня это скважины с координатами и пр., и Вы
      имеете желание вывести эти объекты на чертеж AutoCAD'а, тогда Вы можете сформировать скрипт,
      загрузить его в AutoCAD и получить готовую схему.
      При этом в программе можно предусмотреть создание нужных слоев, текстовых стилей и загрузку
      с указанными координатами заготовленных примитивов.
     
    Ограничения
      Использую с AutoCAD 2000i и AutoCAD Map, английские версии.
     
    Source code prepered to rjPasDoc program
    Форматирование комментариев подготовлено для обработки исходников программой rjPasDoc
    }
     
    unit AScript;
     
    interface
     
    uses
      SysUtils, Types;
     
    { из Utils }
    const
    { Константа возвращаемая при успешном завершении функции }
      _OK_ = 1;
     
    { Константа возвращаемая при неудачном завершении функции }
      _ERROR_ = 0;
    { - из Utils }
     
    type
    { Индексный тип для перечисления символьных обозначений цветов принятых в AutoCAD'е
       TACColourIndex = 1..9; }
      TACColourIndex = 1..9;
    { Перечислимый тип для индексации типов выравнивания при выводе текста.
       TASLabelAlign = ( BL, ML, TL, TC, TR, MR, BR, BC, MC ); }
      TASLabelAlign = ( BL, ML, TL, TC, TR, MR, BR, BC, MC );
     
    { + из Utils }
    { Динамический массив целочисленных точек }
      TPointsArray = array[0..MaxInt div SizeOf(TPoint) -1] of TPoint;
     
    { Указатель на массив точек }
      PPointsArray = ^TPointsArray;
    { - из Utils }
     
    const
    { Unknown error }
      _AS_ERROR_UNKNOWN_ = 1001;
    { Error occure on file write operation }
      _AS_WRITE_ERROR_ = 1010;
    { Block file not found }
      _AS_BLOCK_NOT_FOUND_ = 1020;
     
    {DEFAULT PARAMETERS}
     
    { Path to block files library
       _AS_LIB_PATH_ : string = 'e:\lib\symbols.dwg\';}
      _AS_LIB_PATH_ : string = 'e:\lib\symbols.dwg\';
     
    {Default metrix }
     
    { distanse from centre of inserted block and point to place label _AM_LABEL_DIST_ = 1.5; }
      _AM_LABEL_DIST_ = 1.5;
     
    { AutoCAD colour names _AC_RED_ = 'red';}
      _AC_RED_ = 'red';
    { AutoCAD colour names _AC_YELLOW_ = 'yellow';}
      _AC_YELLOW_ = 'yellow';
    { AutoCAD colour names _AC_GREEN_ = 'green';}
      _AC_GREEN_ = 'green';
    { AutoCAD colour names _AC_CYAN_ = 'cyan';}
      _AC_CYAN_ = 'cyan';
    { AutoCAD colour names _AC_BLUE_ = 'blue';}
      _AC_BLUE_ = 'blue';
    { AutoCAD colour names _AC_MAGENTA_ = 'magenta';}
      _AC_MAGENTA_ = 'magenta';
    { AutoCAD colour names _AC_WHITE_ = 'white';}
      _AC_WHITE_ = 'white';
    { AutoCAD colour names _AC_BYLAYER_ = 'BYLAYER'; }
      _AC_BYLAYER_ = 'BYLAYER';
    { AutoCAD colour names _AC_BYBLOCK_ = 'BYBLOCK';}
      _AC_BYBLOCK_ = 'BYBLOCK';
     
    { AutoCAD colour names }
       AC_ColourNames : array [TACColourIndex] of string = ( _AC_RED_, _AC_YELLOW_, _AC_GREEN_, _AC_CYAN_, _AC_BLUE_, _AC_MAGENTA_, _AC_WHITE_, _AC_BYLAYER_, _AC_BYBLOCK_ );
     
    { Default prefix to automaticaly created layers _AL_LEGEND : string = 'LGND_';}
      _AL_LEGEND : string = 'LGND_';
    { Default prefix to automaticaly created layers _AL_XGRID : string = 'XGRD_';}
      _AL_XGRID : string = 'XGRD_';
    { Default prefix to automaticaly created layers _AL_YGRID : string = 'YGRD_';}
      _AL_YGRID : string = 'YGRD_';
    { Default prefix to automaticaly created layers _AL_DLABEL : string = 'DLBL_';}
      _AL_DLABEL : string = 'DLBL_';
     
    { Default prefix to automaticaly created text styles _AS_LOG_LEGEND : string = 'STL_LEGEND_';}
      _AS_LOG_LEGEND : string = 'STL_LEGEND_';
     
    { Format strings }
    { command PLINE format strings AS_FRMT_PLINE = 'pline %-4.2f,%-4.2f'; }
      AS_FRMT_PLINE = 'pline %-4.2f,%-4.2f ';
     
    { command LINE format strings AS_FRMT_LINE = 'line %-4.2f,%-4.2f'; }
      AS_FRMT_LINE = 'line %-4.2f,%-4.2f %-4.2f,%-4.2f ';
     
    { command LINE format strings AS_FRMT_LINE = 'line %-4.2f,%-4.2f'; }
      AS_FRMT_RECT = 'rectangle %-4.2f,%-4.2f %-4.2f,%-4.2f';
     
    { one POINT format strings AS_FRMT_POINT = '%-4.2f,%-4.2f'; }
      AS_FRMT_POINT = '%-4.2f,%-4.2f ';
     
    { command MTEXT format strings AS_FRMT_MTEXT = '-mtext %-4.2f,%-4.2f j MC r 180 %-4.2f,%-4.2f %-4.1f'; }
      AS_FRMT_MTEXT = '-mtext %-4.2f,%-4.2f j %-s r %-3.1f %-4.2f,%-4.2f %-s';
    // left top just rotate right bootom text
     
    { command MTEXT format strings AS_FRMT_TEXT = '-mtext j %-s s %-s %-4.2f,%-4.2f %-s'; }
      AS_FRMT_TEXT = 'text s %-s j %-s %-4.2f,%-4.2f %-3.1f %-s';
     
    { command LAYER format strings AS_FRMT_LAYER_CREATE = '-layer n %-s s %-s '; }
      AS_FRMT_LAYER_CREATE = '-layer n %-s s %-s ';
     
    { command LAYER format strings AS_FRMT_LAYER_COLOUR = '-layer c %-1d '; }
      AS_FRMT_LAYER_COLOUR = '-layer c %-1d ';
     
    { command COLOR format strings AS_FRMT_COLOUR = '-color %-1d'; }
      AS_FRMT_COLOUR = '-color %-1d';
     
    { command COLOR format strings AS_FRMT_COLOUR_NAME = '-color %-s'; }
      AS_FRMT_COLOUR_NAME = '-color %-s';
     
    { command COLOR format strings AS_FRMT_COLOUR_BYLAYER = '-color BYLAYER'; }
      AS_FRMT_COLOUR_BYLAYER = '-color BYLAYER';
     
    { command COLOR format strings AS_FRMT_TEXT_STYLE = '-style %-s %-s %-4.2f '; }
      AS_FRMT_TEXT_STYLE = '-style %-s %-s %-4.2f ';
     
    { command COLOR format strings AS_FRMT_INSERT = 'insert %-s%-s.dwg %-4.2f,%-4.2f %-1d %-1d 0'; }
      AS_FRMT_INSERT = 'insert %-s %-4.2f,%-4.2f %-4.2f %-4.2f 0';
     
    {******************************************************************************
      Plot multysegment line
      function AS_Polyline( var f : TextFile;
                            var pnts : TPointsArray;
                            count : integer;
                          ) : integer
      f reference to text file, this file must be already opened.
      pnts variable that contained points struct.
      On succese return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.}
    function AS_Polyline( var f : TextFile;
                          var pnts : TPointsArray;
                          count : integer
                        ) : integer;
     
    {******************************************************************************
      Plot single line
      function AS_Line( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
      f reference to text file, this file must be already opened.
      x1, y1, x2, y2 contained points coordinates.
      On successe return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.}
    function AS_Line( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
     
    {******************************************************************************
      Plot rectangle
      function AS_Rect( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
      f reference to text file, this file must be already opened.
      x1, y1, x2, y2 contained corner coordinates.
      On successe return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.}
    function AS_Rect( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
     
    {******************************************************************************
      Plot multiple text with rotate and justification
      function AS_MText( var f : TextFile;
                         left, top, right, bottom, angl : double;
                         const justify, text : string
                       ) : integer;
      f reference to text file, this file must be already opened.
      left, top, right, bottom contained coordinates.
      angl - text rotate angle.
      justify - aligment parameters (see detail).
      On successe return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.}
    function AS_MText( var f : TextFile;
                       left, top, right, bottom, angl : double;
                       const justify, text : string
                     ) : integer;
     
    {******************************************************************************
      Plot text with style and justification
      function AS_Text( var f : TextFile;
                        x, y, angle : double;
                        const style, justify, text : string
                       ) : integer;
      f reference to text file, this file must be already opened.
      x, y - coordinates of point, position of text relatively this point
              depend from justify.
      angle - text rotate angle.
      style - text style.
      justify - aligment parameters (see detail).
      On successe return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.
      NOTE: if AutoCAD at playing script file do not have above text style, error occure.}
    function AS_Text( var f : TextFile;
                      x, y, angle : double;
                      const style, justify, text : string
                     ) : integer;
     
    {******************************************************************************
      Create and set current new text style.
      function AS_TextStyle( var f : TextFile; const StyleName, FontName : string;
                           Size : double ) : integer;
      f reference to text file, this file must be already opened.
      StyleName - name of new style.
      FontName - font name (TTF or SHX)
      Size - font size
      On successe return _OK_
      If error occure then return _ERROR_ }
    function AS_TextStyle( var f : TextFile; const StyleName, FontName : string;
                           Size : double ) : integer;
     
    {******************************************************************************
      Create and set current new layer.
      function AS_LayerCreate( var f : TextFile; const LayerName : string ) : integer;
      f reference to text file, this file must be already opened.
      LayerName - name of created layer.
      On successe return _OK_
      If error occure then return _ERROR_
      Verify global variable AS_LastError to code of error.
      NOTE: if AutoCAD already have above layer, this layer setup current.}
    function AS_LayerCreate( var f : TextFile; const LayerName : string ) : integer;
     
    {******************************************************************************
      Set current colour.
      function AS_Colour( var f : TextFile; colour : integer ) : integer; overload;
      function AS_Colour( var f : TextFile; const colour : string ) : integer; overload;
      f reference to text file, this file must be already opened.
      colour - integer index of new colour.
      colour - string name of the colour.
      Colour must be interval [1..255]
      On successe return _OK_
      If error occure then return _ERROR_
      NOTE: AutoCAD define colour index from [1..255].}
    function AS_Colour( var f : TextFile; colour : integer ) : integer; overload;
    function AS_Colour( var f : TextFile; const colour : string ) : integer; overload;
     
    {******************************************************************************
      Set layer colour.
      function AS_LayerColour( var f : TextFile; colour : integer ) : integer; overload;
      function AS_LayerColour( var f : TextFile; const colour : string ) : integer; overload;
      f reference to text file, this file must be already opened.
      colour - integer index of new colour.
      colour - string name of the colour.
      Colour must be interval [1..255]
      On successe return _OK_
      If error occure then return _ERROR_}
    function AS_LayerColour( var f : TextFile; colour : integer ) : integer; overload;
    function AS_LayerColour( var f : TextFile; const colour : string ) : integer; overload;
     
    {******************************************************************************
      Set current colour to predefined value "BYLAYER".
      function AS_Colour( var f : TextFile; colour : integer ) : integer;
      f reference to text file, this file must be already opened.
      On successe return _OK_
      If error occure then return _ERROR_ }
    function AS_ColourByLayer( var f : TextFile ) : integer;
     
    {******************************************************************************
      Insert AutoCAD block from specified file.
      function AS_InsertBlock( var f : TextFile; const BlockName : string;
                             x, y, xScale, yScale, angle : double ) : integer;
      f reference to text file, this file must be already opened.
      BlockName - name of file containing the block.
      x, y - position to block place
      xScale, yScale - scale factors
      angle - angle to rotate block
      if BlockName do not have full specified path to file then programm search
      file on default library path (see DEFAULT PARAMETERS: DWG.LIB).
      if programm do not find file with name BlockName AS_LastError
      On successe return _OK_
      If error occure then return _ERROR_
      NOTE: usually block is DWG file with simple elements drawing in single
            rectangle (-0.5,-0.5; 0.5, 0.5) }
    function AS_InsertBlock( var f : TextFile; const BlockName : string;
                             x, y, xScale, yScale, angle : double ) : integer;
     
    {******************************************************************************
      Insert AutoCAD block from specified file.
      function AS_LabeledPost( var f : TextFile; const BlockName, aLabel : string;
                             x, y, xScale, yScale, angle, xLabelPos, yLabelPOS,
                             rotate : double; LabelAlign : TASLabelAlign;
                             const style, justify : string ) : integer;
      f reference to text file, this file must be already opened.
      BlockName - name of file containing the block.
      aLabel - text to place as label
      x, y - position to block place
      xScale, yScale - scale factors
      angle - angle to rotate block
      xLabelPos, yLabelPos - position of the text label
      rotate - angle to text rotate
      style - AutoCAD text style (must be created before)
      justify - vertical and horizontal aligment
      On successe return _OK_
      If error occure then return _ERROR_
      NOTE:
      SEE ALSO: AS_InsertBlock; TEXT JUSTIFY. }
    function AS_LabeledPost( var f : TextFile; const BlockName, aLabel : string;
                             x, y, xScale, yScale, angle, xLabelPos, yLabelPOS,
                             rotate : double; LabelAlign : TASLabelAlign;
                             const style, justify : string ) : integer;
     
    {******************************************************************************
      Plot LOG legend.
      function AS_LOGlegend( var f : TextFile; const LOGname, _Min, _Max : string;
                           colour : integer; const rect : TRect ) : integer;
      Plot rectangle, inside plot colour line. On top from this line place text
      with LOG name, on bottom from line at left corner place min value, at right
      corner place max value. All drawing place to created layer _AL_LGND.
      NOTE: Function create new style or update existing text style.
            Style name defined constant _AS_LOG_LEGEND }
    function AS_LOGlegend( var f : TextFile; const LOGname, _Min, _Max : string;
                           colour : integer; const rect : TRect ) : integer;
     
    var
      AS_LastError : integer;
     
    implementation
     
     
    {****************************************************************************}
    function AS_Polyline( var f : TextFile;
                          var pnts : TPointsArray;
                          count : integer
                        ) : integer;
    var
      i : integer;
    begin
      try
        write(f, Format(AS_FRMT_PLINE,[pnts[0].x, pnts[0].y]));
        for i := 1 to count-1 do begin
          write(f, Format(AS_FRMT_POINT,[pnts[i].x, pnts[i].y]));
        end;
        writeln(f, '');
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
        exit;
      end;
      result := _OK_;
    end;
     
    function AS_Line( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_LINE, [x1, y1, x2, y2]));
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
      end;
    end;
     
    function AS_Rect( var f : TextFile; x1, y1, x2, y2 : double ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_RECT, [x1, y1, x2, y2]));
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
      end;
    end;
     
     
    function AS_MText( var f : TextFile;
                       left, top, right, bottom, angl : double;
                       const justify, text : string
                     ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_MTEXT, [left, top, justify, angl, right, bottom, text] ));
        writeln(f, '');
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
        exit;
      end;
    end;
     
    function AS_Text( var f : TextFile;
                      x, y, angle : double;
                      const style, justify, text : string
                     ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_TEXT, [style, justify, x, y, angle, text] ));
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
        exit;
      end;
    end;
     
    function AS_LayerCreate( var f : TextFile; const LayerName : string ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_LAYER_CREATE, [LayerName, LayerName]));
      except
        result := _ERROR_;
        AS_LastError := _AS_ERROR_UNKNOWN_;
      end;
    end;
     
    function AS_Colour( var f : TextFile; colour : integer ) : integer;
    begin
      result := _ERROR_;
      if (colour >= 0) or (colour < 255) then begin
        writeln(f, Format(AS_FRMT_COLOUR, [colour]));
        result := _OK_;
      end;
    end;
     
    function AS_Colour( var f : TextFile; const colour : string ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_COLOUR_NAME, [colour]));
      except
        result := _ERROR_;
      end;
    end;
     
    function AS_ColourByLayer( var f : TextFile ) : integer;
    begin
      result := AS_Colour( f, 'Bylayer' );
    end;
     
    function AS_LayerColour( var f : TextFile; colour : integer ) : integer;
    begin
      result := _OK_;
      try
        writeln(f, Format(AS_FRMT_LAYER_COLOUR, [colour]));
        writeln(f, '');
      except
        result := _ERROR_;
      end;
    end;
     
    function AS_LayerColour( var f : TextFile; const colour : string ) : integer; overload;
    begin
      result := _OK_;
    end;
     
    function AS_TextStyle( var f : TextFile; const StyleName, FontName : string;
                           Size : double ) : integer;
    begin
      result := _OK_;
      try
        writeln( f, Format(AS_FRMT_TEXT_STYLE, [StyleName, FontName, Size]));
      except
        result := _ERROR_;
      end;
    end;
     
    function AS_InsertBlock( var f : TextFile; const BlockName : string;
                             x, y, xScale, yScale, angle : double ) : integer;
    var
      filename : string;
    begin
      result := _OK_;
      filename := BlockName;
      if ExtractFilePath( filename ) = '' then
        filename := _AS_LIB_PATH_ + filename;
      if not FileExists( filename ) then begin
        result := _ERROR_;
        AS_LastError := _AS_BLOCK_NOT_FOUND_;
      end;
      try
        writeln(f, Format(AS_FRMT_INSERT,[filename, x, y, xScale, yScale, angle]));
      except
        result := _ERROR_;
        AS_LastError := _AS_WRITE_ERROR_;
      end;
    end;
     
    function AS_LabeledPost( var f : TextFile; const BlockName, aLabel : string;
                             x, y, xScale, yScale, angle, xLabelPos, yLabelPOS,
                             rotate : double; LabelAlign : TASLabelAlign;
                             const style, justify : string ) : integer;
    var
      H, W : double;
    begin
      result := AS_InsertBlock( f, BlockName, x, y, xScale, yScale, angle );
      if result = _ERROR_ then begin
        exit;
      end;
      //размер области метки ~ по размеру блока на символ, т.е. полагаем, что размер одной буквы порядка размера блока
      // W := length(aLabel) * xScale;
      // H := yScale;
      case LabelAlign of
        BL: result := AS_Text( f, x - xScale * _AM_LABEL_DIST_, y - yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        ML: result := AS_Text( f, x - xScale * _AM_LABEL_DIST_, y, rotate, style, justify, aLabel );
        TL: result := AS_Text( f, x - xScale * _AM_LABEL_DIST_, y + yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        TC: result := AS_Text( f, x, y + yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        TR: result := AS_Text( f, x + xScale * _AM_LABEL_DIST_, y + yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        MR: result := AS_Text( f, x + xScale * _AM_LABEL_DIST_, y, rotate, style, justify, aLabel );
        BR: result := AS_Text( f, x + xScale * _AM_LABEL_DIST_, y - yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        BC: result := AS_Text( f, x, y - yScale * _AM_LABEL_DIST_, rotate, style, justify, aLabel );
        MC: result := AS_Text( f, x, y, rotate, style, justify, aLabel );
      end;
    end;
     
    function AS_LOGlegend( var f : TextFile; const LOGname, _Min, _Max : string;
                           colour : integer; const rect : TRect ) : integer;
    var
      L, H, //ширина и высота прямоугольника
      x1, y1, //начало линии, прямоугольника для текта...
      x2, y2, //конец линии
      xc, yc : double; //центр прямоугольника
    begin
      result := _OK_;
      try
        AS_LayerCreate( f, _AL_LEGEND + LOGname );
        AS_Rect( f, rect.Left, rect.Bottom, rect.Right, rect.Top );
        xc := (rect.Left + rect.Right) / 2.0;
        yc := (rect.Top + rect.Bottom) / 2.0;
        L := rect.Right - rect.Left;
        H := rect.Top - rect.Bottom;
        x1 := rect.Left + L / 10.0;
        x2 := rect.Right - L / 10.0;
        AS_Colour( f, colour );
        AS_Line( f, x1, yc, x2, yc );
        y1 := yc + H / 5.0;
        y2 := rect.Top - H / 5.0;
        AS_ColourByLayer( f );
        AS_TextStyle( f, _AS_LOG_LEGEND + LOGname, 'COMPLEX', L/20.0 );
        AS_MText( f, x1, y1, x2, y2, 0, 'MC', LOGname );
        y1 := yc - H / 10.0;
        y2 := yc - 3.0 * H / 10.0;
        AS_MText( f, x1, y1, xc, y2, 0, 'TL', _Min );
        AS_MText( f, xc, y1, x2, y2, 0, 'TR', _Max );
      except
        result := _ERROR_;
      end;
    end;
     
    end. 

Пример использования:

    { Выводит в скрипт команды вставки из файлов символов скважин в локальных координатах
       Символы помещаются в слой "WELLS" }
    function TfrmWellPlace.PlotWellsSymbol : integer;
    var
      f : TextFile;
      x, y : Double;
      x1, y1,
      x2, y2: integer;
      s : string;
    begin
      AssignFile( f, feFileName.Text );
      try
        //Create file
        Rewrite( f );
        //Create new layer: name=WELLS, colour, line style and othe is default
        AS_LayerCreate(f, 'WELLS');
        with _db.data.qryWellPlace do begin
          if not Active then
            Open();
          First();
          while not Eof do begin
            //get well coordinates
            x := FieldByName('x').asFloat + edXShift.Value;
            y := FieldByName('y').asFloat + edYShift.Value;
            if ckStateSymbol.Checked then
              s := '_w_DEV' //ignore well state symbol, all wells plot simple circle
            else
              s := FieldByName('DWG_file').asString;
            //Plot block from file at specified position
            AS_InsertBlock(f, Lib_Path + s + '.dwg', x, y, Round(edScale.Value), Round(edScale.Value), 0);
            Next();
          end;
          Close();
        end;
      finally
        CloseFile(f);
      end;
    end; 
