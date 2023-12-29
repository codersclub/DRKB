---
Title: Скрытые настройки Delphi
Date: 01.01.2007
---


Скрытые настройки Delphi
========================

::: {.date}
01.01.2007
:::

Some undocumented registry settings of Delphi 5 (which -slightly
adapted- might also work with Delphi 4 and below) modify the behavior of
the Delphi component palette in a manner you may like!

Most values are stored as strings, and boolean values are represented as
\"1\" for true and \"0\" for false. All values are stored in

HKEY\_CURRENT\_USER

As always, use of this information is at your own risk... ;-)

Software\\Borland\\Delphi\\5.0\\Extras\\AutoPaletteSelect

will cause a tab on the component palette to be automatically selected
when the mouse is hovering over it. If the mouse is in the top two-
thirds (2/3) of the tab, the palette for that tab will automatically be
displayed.

Software\\Borland\\Delphi\\5.0\\Extras\\AutoPaletteScroll

will make you scroll left and right automatically whenever the mouse is
positioned over the relevant arrow.

Software\\Borland\\Delphi\\5.0\\Editor\\Options\\NoCtrlAltKeys

Disables menu item Ctrl+Alt key sequences for international keyboards

Software\\Borland\\Delphi\\5.0\\Form Design\\AlwaysEnableMiddleEast

Forces Right-to-Left text in the form designer (?)

Software\\Borland\\Delphi\\5.0\\Extras\\FontNamePropertyDisplayFontNames

Display the fonts in the object inspector dropdown in the font\'s actual
style (slow with many fonts installed). See also
DsgnIntf.FontNamePropertyDisplayFontNames in D5.

Software\\Borland\\Delphi\\5.0\\Compiling\\ShowCodeInsiteErrors

Show compilation errors found by CodeInsite in the message view window

Software\\Borland\\Delphi\\5.0\\Globals\\PropValueColor

Fill in with a string like \"clGreen\" to change the color of the right
half (properties) of the Object Inspector.

Software\\Borland\\Delphi\\5.0\\Disabled Packages

This is the place you put Delphi Direct :)

Software\\Borland\\Delphi\\5.0\\Globals\\TwoDigitYearCenturyWindow

Default value for TwoDigitYearCenturyWindow (see the help file)

Software\\Borland\\Delphi\\5.0\\Component Templates\\CCLibDir

Alternative component templates directory (shared/network)

Software\\Borland\\Delphi\\5.0\\FormDesign\\DefaultFont=\"Arial,8\"
\[D4\] or \"Arial,8,Bold\" \[D5\]

The default for new forms (you might prefer using the repository\'s
default form checkbox instead)

Software\\Borland\\Delphi\\5.0\\Wizards

Alternate key to store Expert/Wizard DLLs to load at startup

Software\\Borland\\Delphi\\5.0\\Debugging\\DontPromptForJITDebugger

Don\'t ask to change the current JIT debugger (?)

Software\\Borland\\Delphi\\5.0\\Version Control\\VCSManager

The DLL used for the version control interface in the IDE.

Software\\Borland\\Delphi\\5.0\\Globals\\PrivateDir

A way to specify an alternative directory for the location for the
Delphi configuration files when running the application from a network
drive or the CD-ROM.

Software\\Borland\\Delphi\\5.0\\Main Window\\Palette Visible

Software\\Borland\\Delphi\\5.0\\Main Window\\Speedbar Visible

Software\\Borland\\Delphi\\5.0\\Main Window\\Palette Hints

Software\\Borland\\Delphi\\5.0\\Main Window\\Speedbar Hints

Software\\Borland\\Delphi\\5.0\\Main Window\\Split Position

These seem to have no effect at runtime, but are read by the IDE. The
actually used values come from

HKEY\_CURRENT\_USER\\Software\\Borland\\Delphi\\5.0\\Toolbars

Software\\Borland\\Delphi\\5.0\\ProjectManager\\Dockable

Software\\Borland\\Delphi\\5.0\\PropertyInspector\\Dockable

Software\\Borland\\Delphi\\5.0\\CallStackWindow\\Dockable

Software\\Borland\\Delphi\\5.0\\ModuleWindow\\Dockable

Read but unused settings. Used values come from DSK files.

There are lots of other interesting registry keys that aren\'t
modifiable in the IDE, but they all have values written by default, so
you can find and play with them much easier.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
