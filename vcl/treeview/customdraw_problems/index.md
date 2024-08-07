---
Title: TTreeView. Проблемы CustomDraw
Author: Rustam Kafarov
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


TTreeView. Проблемы CustomDraw
==============================

При использовании компонента TTreeView возникают проблемы при
собственной отрисовке содержимого компонента в событиях OnCustomDraw,
OnCustomDrawItem, OnAdvancedCustomDraw, OnAdvancedCustomDrawItem.
Проблема проявляется когда свойства Canvas компонента устанавливаются
вторично. К примеру, при попытке изменить цвет фонта во второй раз,
соотвествующих изменений НЕ ПОСЛЕДУЕТ. Тоже самое и со свойствами Brush,
Pen.

Проверено на Дельфи 5.

Контрольный пример (на форме TTreeView и TCheckBox):

    procedure TForm1.TreeView1AdvancedCustomDrawItem(Sender: TCustomTreeView;
      Node: TTreeNode; State: TCustomDrawState; Stage: TCustomDrawStage;
      var PaintImages, DefaultDraw: Boolean);
    var
      ARect: TRect;
      S: string;
    begin
      if not CheckBox1.Checked then
        Exit;
      case Stage of
        cdPostPaint:
          begin
            ARect := Node.DisplayRect(True);
            ARect.Right := TreeView1.ClientWidth;
            with TreeView1.Canvas do
            begin
              if cdsSelected in State then
                Brush.Color := clHighlight
              else
                Brush.Color := clWindow;
              FillRect(ARect);
              Font.Color := clGreen;
              S := 'AbsoluteIndex : ' + IntToStr(Node.AbsoluteIndex);
              TextOut(ARect.Left, ARect.Top, S);
              // цвет шрифта должен поменяться!!!
              Font.Color := clBlue;
              // Но он не меняется :-(((
              TextOut(ARect.Left + TextWidth(S) + 20, ARect.Top, Node.Text);
            end;
          end;
      end; { Case }
    end;
     
    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      TreeView1.Repaint;
    end;

**ТИПОВЫЕ РЕШЕНИЯ**

Использовать API функции Windows такие как SetTextColor, SelectObject и
т.д, передавая им в качестве первого параметра Canvas.Handle.

**КОММЕНТАРИЙ**

Проверено (Delphi 5 Update Pack 1, WinNT, Win2000). Действительно,
эффект имеет место быть. Вероятно, Борланд перемудрил что-то в своем
кэше ресурсов GDI (класс TCanvas).

При присваивании Font.Color изменяется только внутреннее поле FColor. В
методе TCanvas.TextOut не выполняется SetTextColor(FHandle,
ColorToRGB(FFont.Color)), как это сделано в TCanvas.Draw. Следовательно,
мы имеем более глобальную проблему, чем рисование узлов дерева вручную.


