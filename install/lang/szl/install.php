<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['admindirname'] = 'Katalog admin';
$string['availablelangs'] = 'Przistympne paketu gŏdkowe';
$string['chooselanguagehead'] = 'Ôbier gŏdka';
$string['chooselanguagesub'] = 'Proszã ôbrać gŏdka do instalacyje. Ta gŏdka bydzie tyż użyty za wychodnŏ gŏdka placu, przi czym może być niyskorzij zmiyniōny.';
$string['clialreadyconfigured'] = 'Zbiōr config.php już istnieje. Użyj admin/cli/install_database.php jeźli chcesz zainstalować Moodle dlŏ tyj strōny.';
$string['clialreadyinstalled'] = 'Zbiōr config.php już istnieje. Użyj admin/cli/install_database.php jeźli chcesz zaktualizować Moodle dlŏ tyj strōny.';
$string['cliinstallheader'] = 'Program instalacyjny Moodle {$a} z lynije nakŏzań';
$string['clitablesexist'] = 'Tabule bazy danych już istniejōm, instalacyjŏ  niy może kōntynuować.';
$string['databasehost'] = 'Host bazy danych';
$string['databasename'] = 'Miano bazy danych';
$string['databasetypehead'] = 'Ôbier kludzŏcz bazy danych';
$string['dataroot'] = 'Katalog danych';
$string['datarootpermission'] = 'Prawa katalogōw danych';
$string['dbprefix'] = 'Prefiks tabulōw';
$string['dirroot'] = 'Katalog Moodle';
$string['environmenthead'] = 'Wybadujã strzodowisko (ustawiyniŏ) ...';
$string['environmentsub2'] = 'Kożde wydanie Moodle mŏ pewne minimalne wymŏganiŏ wersyje PHP i pewnõ liczbã musowych rozszyrzyń PHP. Połnŏ kōntrola strzodowiska ôdbywŏ sie przed kożdõ instalacyjōm i aktualizacyjōm. Proszymy ô kōntakt z administratorym serwera, jeźli niy wiysz jak zainstalować nowõ wersyjõ abo włōnczyć rozszyrzynie PHP.';
$string['errorsinenvironment'] = 'Kōntrola strzodowiska zakōńczōnōm #niypowodzynie!';
$string['installation'] = 'Instalacyjŏ';
$string['langdownloaderror'] = 'Niystety gŏdka "{$a}" niy może ôstać pobrany. Proces instalacyje bydzie kōntynuowany w gŏdce angelskim.';
$string['memorylimithelp'] = '<p>Limit pamiyńci PHP dlŏ Twojigo serwera je ustawiōny terŏźnie na {$a}.</p>

<p> Może to stworzić sytuacyjõ, co w nij Moodle bydzie mioł w prziszłości problymy z pamiyńciōm, ôsobliwie jeźli mŏsz udostympniōnych moc modułōw i/abo moc używŏczōw.</p>

<p>Jeźli je to możliwe, zalycōmy ustawiynie kōnfiguracyje PHP z wyższym limitym, bp. 40M.
Istnieje pŏrã spōsobōw przekludzyniŏ tyj ôperacyje, co możesz sprōbować:</p>
<ol>
<li>Jeźli możesz przekompiluj PHP za pōmocōm <i>--enable-memory-limit</i>.
Przizwoli to Moodle ustawić samoczynnie limit pamiyńci.</li>
<li>Jeźli mŏsz przistymp do zbioru konfiguracyjnego php.ini, możesz w nim zmiynić ustawiynie <b>memory_limit</b> do srogości bp. 40M. W przipŏdku, kej niy posiadŏsz przistympu możesz poprosić swojigo administratora coby zrobiōł to za Ciebie.</li>
<li>Na niykerych serwerach PHP idzie stworzić zbiōr. htaccess w katalogu Moodle zawiyrajōncy miyniōnõ lynijõ:
<blockquote><div>php_value memory_limit 40M</div></blockquote>
<p>A dyć na niykerych serwerach bydzie niy dozwolało to nŏleżne fungowanie <b>wszyjskich</b> strōn PHP (ujzdrzisz błyndy na wyświytlanych strōnach), tedy bydziesz musioł wychrōnić zbiōr .htaccess.</p></li>
</ol>';
$string['paths'] = 'Chodnika';
$string['pathserrcreatedataroot'] = 'Katalog danych ({$a->dataroot}) niy może ôstać utworzōny bez instalatōr.';
$string['pathshead'] = 'Potwiyrdź chodnika';
$string['pathsrodataroot'] = 'Głowny katalog danych niy ma uprawniyń do zŏpisu.';
$string['pathsroparentdataroot'] = 'Nadrzyndny katalog ({$a->parent}) je ino do ôdczytu. Katalog danych ({$a->dataroot}) niy może ôstać utworzōny bez instalatōr.';
$string['pathssubadmindir'] = 'Niyliczne portale używajōm URL /admin za ekstra adresy panelu sterowaniŏ. Niystety je to sporne ze sztandardowyj lokalizacyjōm folderu strōn administratora Moodle. Idzie to sprawić bez pōmianã miana katalogu administratora w instalacyje i podanie tego miana sam, bp.: <em>moodleadmin.</em> Powroza administratora Moodle bydōm autōmatycznie poprawiōne.';
$string['pathssubdataroot'] = 'Potrzebny je przestrzyństwo, kaj Moodle może zapisować ladowane dō niego zbiory. Katalog tyn winiyn mieć prawo do ôdczyt i ZŎPISU  bez używŏcza serwera WWW (porzōnd &quot;nobody&quot; abo &quot;apache&quot;), ale może być być przistympny bezpostrzednio bez nec. Instalatōr sprōbuje go utworzić, jeźli niy istnieje.';
$string['pathssubdirroot'] = 'Połny chodnik do katalogu z instalacyjōm Moodle.';
$string['pathssubwwwroot'] = 'Połnŏ adresa internetowy, pod kerym Moodle bydzie przistympny. Moodle niy może być przistympny przi użyciu moc adres. Jeźli twōj plac mŏ pŏrã adres publicznych, przinŏleży skōnfigurować trwałe przekierowania ze wszyjskich z nich na jedyn. Jeźli Twōj plac je przistympny tak z intranetu i Internetu, używej z publicznyj adresy i gezecōw DNS tak, coby używŏcze Intranetu używali tyż z adresy publicznego. Jeźli adresa niy ma nŏleżny, przinŏleży zaś sztartnōńć instalacyjõ z inkszym adresōm.';
$string['pathsunsecuredataroot'] = 'Lokalizacyjŏ głownego katalogu danych niy ma bezpiecznŏ';
$string['pathswrongadmindir'] = 'Katalog admin niy istnieje';
$string['phpextension'] = 'rozszyrzynie PHP {$a}';
$string['phpversion'] = 'Wersyjŏ PHP';
$string['phpversionhelp'] = '<p>Moodle wymŏgŏ wersyje PHP aby 5.6.5 abo 7.1 (7.0.x mŏ pewne ôgraniczyniŏ motora).</p>
<p>Aktualnie używŏsz wersyje {$a}.</p>
<p>Musisz zaktualizować PHP abo przeniyś na host z nowszõ wersyjōm PHP.</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Widzisz tã strōnã, pōniywŏż z powodzyniym zainstalowołś i sztartnōłś <strong>{$a->packname} {$a->packversion}</strong> na swojim kōmputrze.';
$string['welcomep30'] = 'Tyn instalatōr <strong>{$a->installername}</strong> zawiyrŏ aplikacyje, by stworzić strzodowisko, co w niymu bydzie fungować <strong>Moodle</strong>, to znaczy';
$string['welcomep40'] = 'Paket zawiyrŏ <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.';
$string['welcomep50'] = 'Wszyjske aplikacyje w tym pakecie mŏja włŏsne, ôsobne licyncyje. Kōmpletny paket <strong>{$a->installername}</strong> je <a href="http://www.opensource.org/docs/definition_plain.html">open source</a> i je dystrybuowany na <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a> licyncyje.';
$string['welcomep60'] = 'Nastepujące strōny przekludzōm cie bez instalacyjõ <strong>Moodle</strong> na twojim kōmputrze. Możesz zaakceptować ustawiyniŏ wychodne, abo ôpcyjōnalnie, przipasować jy do swojich potrzeb.';
$string['welcomep70'] = 'Kliknij knefel "Dalij" coby kōntynuować instalacyjõ <strong>Moodle</strong>.';
$string['wwwroot'] = 'Adresa w necu';