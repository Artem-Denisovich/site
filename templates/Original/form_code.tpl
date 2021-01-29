<?
$form_code = <<<COD
          <tr align="center" valign="middle">
            <td><span class="dats">
              <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline('o')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
              </span></td>
            <td><span class="dats">
              <input type="button" class="button" accesskey="r" name="addbbcode18" value="RUS" style="width: 40px" onClick="bbstyle(18)" onMouseOver="helpline('r')" />
              </span></td>
          </tr>
          <tr>
            <td colspan="9">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td nowrap><span class="dats"> &nbsp;$lang[font_color]:
                    <select name="addbbcode20" onChange="bbfontstyle('[color=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
                      <option style="color:black; background-color: #FAFAFA" value="#444444" class="dats">$lang[default]</option>
                      <option style="color:darkred; background-color: #FAFAFA" value="darkred" class="dats">$lang[Dark_red]</option>
                      <option style="color:red; background-color: #FAFAFA" value="red" class="dats">$lang[Red]</option>
                      <option style="color:orange; background-color: #FAFAFA" value="orange" class="dats">$lang[Orange]</option>
                      <option style="color:brown; background-color: #FAFAFA" value="brown" class="dats">$lang[Brown]</option>
                      <option style="color:yellow; background-color: #FAFAFA" value="yellow" class="dats">$lang[Yellow]</option>
                      <option style="color:green; background-color: #FAFAFA" value="green" class="dats">$lang[Green]</option>
                      <option style="color:olive; background-color: #FAFAFA" value="olive" class="dats">$lang[Olive]</option>
                      <option style="color:cyan; background-color: #FAFAFA" value="cyan" class="dats">$lang[Cyan]</option>
                      <option style="color:blue; background-color: #FAFAFA" value="blue" class="dats">$lang[Blue]</option>
                      <option style="color:darkblue; background-color: #FAFAFA" value="darkblue" class="dats">$lang[Dark_blue]</option>
                      <option style="color:indigo; background-color: #FAFAFA" value="indigo" class="dats">$lang[Indigo]</option>
                      <option style="color:violet; background-color: #FAFAFA" value="violet" class="dats">$lang[Violet]</option>
                      <option style="color:white; background-color: #FAFAFA" value="white" class="dats">$lang[White]</option>
                      <option style="color:black; background-color: #FAFAFA" value="black" class="dats">$lang[Black]</option>
                    </select> &nbsp;$lang[Font_size]:<select name="addbbcode22" onChange="bbfontstyle('[size=' + this.form.addbbcode22.options[this.form.addbbcode22.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
                      <option value="7" class="dats">$lang[Font_vsmall]</option>
                      <option value="9" class="dats">$lang[Font_small]</option>
                      <option value="12" selected class="dats">$lang[default]</option>
                      <option value="18" class="dats">$lang[Font_big]</option>
                      <option  value="24" class="dats">$lang[Font_vbig]</option>
                    </select>
                    </span></td>
                  <td nowrap="nowrap" align="right"><span class="dats"> <a href="javascript:bbstyle(-1)" class="dats" onMouseOver="helpline('a')">$lang[Close_tags]</a></span></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="9"> <span class="dats">
              <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="$lang[Help_style]" />
              </span></td>
          </tr>
COD;
?>