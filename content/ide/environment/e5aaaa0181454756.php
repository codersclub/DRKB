<h1>Скрытые настройки Delphi</h1>
<div class="date">01.01.2007</div>



<p>Some undocumented registry settings of Delphi 5 (which -slightly adapted- might also work with Delphi 4 and below) modify the behavior of the Delphi component palette in a manner you may like!</p>
<p>Most values are stored as strings, and boolean values are represented as "1" for true and "0" for false. All values are stored in </p>

<p>HKEY_CURRENT_USER</p>

<p>As always, use of this information is at your own risk... ;-)</p>

<p>Software\Borland\Delphi\5.0\Extras\AutoPaletteSelect</p>

<p>will cause a tab on the component palette to be automatically selected when the mouse is hovering over it. If the mouse is in the top two- thirds (2/3) of the tab, the palette for that tab will automatically be displayed.</p>

<p>Software\Borland\Delphi\5.0\Extras\AutoPaletteScroll</p>

<p>will make you scroll left and right automatically whenever the mouse is positioned over the relevant arrow.</p>

<p>Software\Borland\Delphi\5.0\Editor\Options\NoCtrlAltKeys</p>

<p>Disables menu item Ctrl+Alt key sequences for international keyboards</p>

<p>Software\Borland\Delphi\5.0\Form Design\AlwaysEnableMiddleEast</p>

<p>Forces Right-to-Left text in the form designer (?)</p>

<p>Software\Borland\Delphi\5.0\Extras\FontNamePropertyDisplayFontNames</p>

<p>Display the fonts in the object inspector dropdown in the font's actual style (slow with many fonts installed). See also DsgnIntf.FontNamePropertyDisplayFontNames in D5.</p>

<p>Software\Borland\Delphi\5.0\Compiling\ShowCodeInsiteErrors</p>

<p>Show compilation errors found by CodeInsite in the message view window</p>

<p>Software\Borland\Delphi\5.0\Globals\PropValueColor</p>

<p>Fill in with a string like "clGreen" to change the color of the right half (properties) of the Object Inspector.</p>

<p>Software\Borland\Delphi\5.0\Disabled Packages</p>

<p>This is the place you put Delphi Direct :)</p>

<p>Software\Borland\Delphi\5.0\Globals\TwoDigitYearCenturyWindow</p>

<p>Default value for TwoDigitYearCenturyWindow (see the help file)</p>

<p>Software\Borland\Delphi\5.0\Component Templates\CCLibDir</p>

<p>Alternative component templates directory (shared/network)</p>

<p>Software\Borland\Delphi\5.0\FormDesign\DefaultFont="Arial,8" [D4] or "Arial,8,Bold" [D5]</p>

<p>The default for new forms (you might prefer using the repository's default form checkbox instead)</p>

<p>Software\Borland\Delphi\5.0\Wizards</p>

<p>Alternate key to store Expert/Wizard DLLs to load at startup</p>

<p>Software\Borland\Delphi\5.0\Debugging\DontPromptForJITDebugger</p>

<p>Don't ask to change the current JIT debugger (?)</p>

<p>Software\Borland\Delphi\5.0\Version Control\VCSManager</p>

<p>The DLL used for the version control interface in the IDE.</p>

<p>Software\Borland\Delphi\5.0\Globals\PrivateDir</p>

<p>A way to specify an alternative directory for the location for the Delphi configuration files when running the application from a network drive or the CD-ROM.</p>

<p>Software\Borland\Delphi\5.0\Main Window\Palette Visible</p>
<p>Software\Borland\Delphi\5.0\Main Window\Speedbar Visible</p>
<p>Software\Borland\Delphi\5.0\Main Window\Palette Hints</p>
<p>Software\Borland\Delphi\5.0\Main Window\Speedbar Hints</p>
<p>Software\Borland\Delphi\5.0\Main Window\Split Position</p>

<p>These seem to have no effect at runtime, but are read by the IDE. The actually used values come from</p>

<p>HKEY_CURRENT_USER\Software\Borland\Delphi\5.0\Toolbars</p>

<p>Software\Borland\Delphi\5.0\ProjectManager\Dockable</p>
<p>Software\Borland\Delphi\5.0\PropertyInspector\Dockable</p>
<p>Software\Borland\Delphi\5.0\CallStackWindow\Dockable</p>
<p>Software\Borland\Delphi\5.0\ModuleWindow\Dockable</p>

<p>Read but unused settings. Used values come from DSK files. </p>

<p>There are lots of other interesting registry keys that aren't modifiable in the IDE, but they all have values written by default, so you can find and play with them much easier.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

