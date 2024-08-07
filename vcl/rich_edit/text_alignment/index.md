---
Title: Выравнивание текста в TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Выравнивание текста в TRichEdit
===============================

    uses
      RichEdit;
    
    // Using the Paragraph property 
    procedure RE_AlignText1(ARichEdit: TRichEdit; alignment: TAlignment);
    begin
      ARichEdit.Paragraph.Alignment := alignment;
    end;
     
    // Using PARAFORMAT2; nonVCL 
    procedure RE_AlignText2(ARichEdit: TRichEdit; alignment: TAlignment);
    var
      pf2: PARAFORMAT2;
    begin
      FillChar(pf2, SizeOf(pf2), 0);
      pf2.cbSize := SizeOf(PARAFORMAT2);
      SendMessage(ARichEdit.Handle, EM_GETPARAFORMAT, 0, Longint(@pf2));
      pf2.dwMask := PFM_ALIGNMENT;
      case alignment of
        taLeftJustify: pf2.wAlignment := PFA_LEFT;
        taCenter: pf2.wAlignment := PFA_CENTER;
        taRightJustify: pf2.wAlignment := PFA_RIGHT;
      end;
      SendMessage(ARichEdit.Handle, EM_SETPARAFORMAT, 0, Longint(@pf2));
    end;
    
    // Example: Right align text 
    // Beispiel: Text rechtsbundig ausrichten 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      RE_AlignText2(RichEdit1, taRightJustify);
    end;

