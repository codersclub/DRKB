<h1>TTreeView. Проблемы CustomDraw</h1>
<div class="date">01.01.2007</div>

Автор: Rustam Kafarov </p>
<p>При использовании компонента TTreeView возникают проблемы при собственной отрисовке содержимого компонента в событиях OnCustomDraw, OnCustomDrawItem, OnAdvancedCustomDraw, OnAdvancedCustomDrawItem. Проблема проявляется когда свойства Canvas компонента устанавливаются вторично. К примеру, при попытке изменить цвет фонта во второй раз, соотвествующих изменений НЕ ПОСЛЕДУЕТ. Тоже самое и со свойствами Brush, Pen. </p>
<p>Проверено на Дельфи 5. </p>
<p>Контрольный пример (на форме TTreeView и TCheckBox): </p>
<pre>procedure TForm1.TreeView1AdvancedCustomDrawItem(Sender: TCustomTreeView;
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
</pre>
<p>ТИПОВЫЕ РЕШЕНИЯ </p>
<p>Использовать API функции Windows такие как SetTextColor, SelectObject и т.д, передавая им в качестве первого параметра Canvas.Handle. </p>
<p>КОММЕНТАРИЙ </p>
<p>Проверено (Delphi 5 Update Pack 1, WinNT, Win2000). Действительно, эффект имеет место быть. Вероятно, Борланд перемудрил что-то в своем кэше ресурсов GDI (класс TCanvas). </p>
<p>При присваивании Font.Color изменяется только внутреннее поле FColor. В методе TCanvas.TextOut не выполняется SetTextColor(FHandle, ColorToRGB(FFont.Color)), как это сделано в TCanvas.Draw. Следовательно, мы имеем более глобальную проблему, чем рисование узлов дерева вручную. </p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
