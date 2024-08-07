---
Title: Различные стили подчеркивания для TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Различные стили подчеркивания для TRichEdit
===========================================

    uses
      RichEdit;
    
    // Underline styles 
    const
      CFU_UNDERLINETHICK = 9;
      CFU_UNDERLINEWAVE = 8;
      CFU_UNDERLINEDASHDOTDOT = 7;
      CFU_UNDERLINEDASHDOT = 6;
      CFU_UNDERLINEDASH = 5;
      CFU_UNDERLINEDOTTED = 4;
      CFU_UNDERLINE = 1;
      CFU_UNDERLINENONE = 0;
    
    procedure RE_SetCharFormat(ARichEdit: TRichEdit; AUnderlineType: Byte; AColor: Word);
    var
      // The CHARFORMAT2 structure contains information about 
      // character formatting in a rich edit control. 
      Format: CHARFORMAT2;
    begin
      FillChar(Format, SizeOf(Format), 0);
      with Format do
      begin
        cbSize := SizeOf(Format);
        dwMask := CFM_UNDERLINETYPE;
        bUnderlineType := AUnderlineType or AColor;
        ARichEdit.Perform(EM_SETCHARFORMAT, SCF_SELECTION, Longint(@Format));
      end;
    end;
    
    // Underline the current selection with a CFU_UNDERLINEWAVE line style (color red); 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      RE_SetCharFormat(RichEdit1, CFU_UNDERLINEWAVE, $50);
    end;

