<?php require('Views/header.php'); ?>
<?php ini_set('display_errors','off'); ?>


<h1>Bienvenue !</h1>
<p>Connectez-vous pour accéder au dashboard.</p>
<table class="doctable table">
        <caption><strong>
         Les caractères suivants sont reconnus dans le paramètre
         <code class="parameter">format</code>
        </strong></caption>
        
         <thead>
          <tr>
           <th>Caractères pour le paramètre <code class="parameter">format</code></th>
           <th>Description</th>
           <th>Exemple de valeurs retournées</th>
          </tr>

         </thead>

         <tbody class="tbody">
          <tr>
           <td style="text-align: center;"><em class="emphasis">Jour</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">d</code></td>
           <td>Jour du mois, sur deux chiffres (avec un zéro initial)</td>
           <td><code class="literal">01</code> à <code class="literal">31</code></td>
          </tr>

          <tr>
           <td><code class="literal">D</code></td>
           <td>Jour de la semaine, en trois lettres (et en anglais - par défaut : en anglais, ou sinon, dans la langue locale du serveur)</td>
           <td><code class="literal">Mon</code> à <code class="literal">Sun</code></td>
          </tr>

          <tr>
           <td><code class="literal">j</code></td>
           <td>Jour du mois sans les zéros initiaux</td>
           <td><code class="literal">1</code> à <code class="literal">31</code></td>
          </tr>

          <tr>
           <td><code class="literal">l</code> ('L' minuscule)</td>
           <td>Jour de la semaine, textuel, version longue, en anglais</td>
           <td><code class="literal">Sunday</code> à <code class="literal">Saturday</code></td>
          </tr>

          <tr>
           <td><code class="literal">N</code></td>
           <td>Représentation numérique ISO-8601 du jour de la semaine</td>
           <td><code class="literal">1</code> (pour Lundi) à <code class="literal">7</code> (pour Dimanche)</td>
          </tr>

          <tr>
           <td><code class="literal">S</code></td>
           <td>Suffixe ordinal d'un nombre pour le jour du mois, en anglais, sur deux lettres</td>
           <td>
            <code class="literal">st</code>, <code class="literal">nd</code>, <code class="literal">rd</code> ou
            <code class="literal">th</code>.  Fonctionne bien avec <code class="literal">j</code>
           </td>
          </tr>

          <tr>
           <td><code class="literal">w</code></td>
           <td>Jour de la semaine au format numérique</td>
           <td><code class="literal">0</code> (pour dimanche) à <code class="literal">6</code> (pour samedi)</td>
          </tr>

          <tr>
           <td><code class="literal">z</code></td>
           <td>Jour de l'année</td>
           <td><code class="literal">0</code> à <code class="literal">365</code></td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Semaine</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">W</code></td>
           <td>Numéro de semaine dans l'année ISO-8601, les semaines commencent
            le lundi</td>
           <td>Exemple : <code class="literal">42</code> (la 42ème semaine de l'année)</td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Mois</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">F</code></td>
           <td>Mois, textuel, version longue; en anglais, comme
            <code class="literal">January</code> ou <code class="literal">December</code></td>
           <td><code class="literal">January</code> à <code class="literal">December</code></td>
          </tr>

          <tr>
           <td><code class="literal">m</code></td>
           <td>Mois au format numérique, avec zéros initiaux</td>
           <td><code class="literal">01</code> à <code class="literal">12</code></td>
          </tr>

          <tr>
           <td><code class="literal">M</code></td>
           <td>Mois, en trois lettres, en anglais</td>
           <td><code class="literal">Jan</code> à <code class="literal">Dec</code></td>
          </tr>

          <tr>
           <td><code class="literal">n</code></td>
           <td>Mois sans les zéros initiaux</td>
           <td><code class="literal">1</code> à <code class="literal">12</code></td>
          </tr>

          <tr>
           <td><code class="literal">t</code></td>
           <td>Nombre de jours dans le mois</td>
           <td><code class="literal">28</code> à <code class="literal">31</code></td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Année</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">L</code></td>
           <td>Est ce que l'année est bissextile</td>
           <td><code class="literal">1</code> si bissextile, <code class="literal">0</code> sinon.</td>
          </tr>

          <tr>
           <td><code class="literal">o</code></td>
           <td>La numérotation de semaine dans l'année ISO-8601. C'est la même valeur que
            <code class="literal">Y</code>, excepté si le numéro de la semaine ISO
            (<code class="literal">W</code>) appartient à l'année précédente ou suivante,
            cette année sera utilisée à la place.</td>
           <td>Exemples : <code class="literal">1999</code> ou <code class="literal">2003</code></td>
          </tr>

          <tr>
           <td><code class="literal">Y</code></td>
           <td>Année sur 4 chiffres</td>
           <td>Exemples : <code class="literal">1999</code> ou <code class="literal">2003</code></td>
          </tr>

          <tr>
           <td><code class="literal">y</code></td>
           <td>Année sur 2 chiffres</td>
           <td>Exemples : <code class="literal">99</code> ou <code class="literal">03</code></td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Heure</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">a</code></td>
           <td>Ante meridiem et Post meridiem en minuscules</td>
           <td><code class="literal">am</code> ou <code class="literal">pm</code></td>
          </tr>

          <tr>
           <td><code class="literal">A</code></td>
           <td>Ante meridiem et Post meridiem en majuscules</td>
           <td><code class="literal">AM</code> ou <code class="literal">PM</code></td>
          </tr>

          <tr>
           <td><code class="literal">B</code></td>
           <td>Heure Internet Swatch</td>
           <td><code class="literal">000</code> à <code class="literal">999</code></td>
          </tr>

          <tr>
           <td><code class="literal">g</code></td>
           <td>Heure, au format 12h, sans les zéros initiaux</td>
           <td><code class="literal">1</code> à <code class="literal">12</code></td>
          </tr>

          <tr>
           <td><code class="literal">G</code></td>
           <td>Heure, au format 24h, sans les zéros initiaux</td>
           <td><code class="literal">0</code> à <code class="literal">23</code></td>
          </tr>

          <tr>
           <td><code class="literal">h</code></td>
           <td>Heure, au format 12h, avec les zéros initiaux</td>
           <td><code class="literal">01</code> à <code class="literal">12</code></td>
          </tr>

          <tr>
           <td><code class="literal">H</code></td>
           <td>Heure, au format 24h, avec les zéros initiaux</td>
           <td><code class="literal">00</code> à <code class="literal">23</code></td>
          </tr>

          <tr>
           <td><code class="literal">i</code></td>
           <td>Minutes avec les zéros initiaux</td>
           <td><code class="literal">00</code> à <code class="literal">59</code></td>
          </tr>

          <tr>
           <td><code class="literal">s</code></td>
           <td>Secondes avec zéros initiaux</td>
           <td><code class="literal">00</code> à <code class="literal">59</code></td>
          </tr>

          <tr>
           <td><code class="literal">u</code></td>
           <td>
            Microsecondes. Notez que la fonction
            <span class="function"><a href="function.date.php" class="function">date()</a></span> génèrera toujours
            <code class="literal">000000</code> vu qu'elle prend un paramètre de type
            entier, alors que la méthode <span class="methodname"><strong>DateTime::format()</strong></span>
            supporte les microsecondes si <span class="classname"><a href="class.datetime.php" class="classname">DateTime</a></span> a
            été créée avec des microsecondes.
           </td>
           <td>Exemple : <code class="literal">654321</code></td>
          </tr>

          <tr>
           <td><code class="literal">v</code></td>
           <td>
            Millisecondes. Même note que pour
            <code class="literal">u</code>.
           </td>
           <td>Exemple: <code class="literal">654</code></td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Fuseau horaire</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">e</code></td>
           <td>L'identifiant du fuseau horaire</td>
           <td>Exemples : <code class="literal">UTC</code>, <code class="literal">GMT</code>, <code class="literal">Atlantic/Azores</code></td>
          </tr>

          <tr>
           <td><code class="literal">I</code> (i majuscule)</td>
           <td>L'heure d'été est activée ou pas</td>
           <td><code class="literal">1</code> si oui, <code class="literal">0</code> sinon.</td>
          </tr>

          <tr>
           <td><code class="literal">O</code></td>
           <td>Différence d'heures avec l'heure de Greenwich (GMT), sans
            deux-points entre les heures et les minutes</td>
           <td>Exemple : <code class="literal">+0200</code></td>
          </tr>

          <tr>
           <td><code class="literal">P</code></td>
           <td>Différence avec l'heure Greenwich (GMT) avec un deux-points
            entre les heures et les minutes</td>
           <td>Exemple : <code class="literal">+02:00</code></td>
          </tr>

          <tr>
           <td><code class="literal">p</code></td>
           <td>Identique à <code class="literal">P</code>, mais retourne <code class="literal">Z</code> au lieu de <code class="literal">+00:00</code></td>
           <td>Exemple : <code class="literal">+02:00</code></td>
          </tr>

          <tr>
           <td><code class="literal">T</code></td>
           <td>Abréviation du fuseau horaire, si connu ; sinon décalage depuis GMT</td>
           <td>Exemples : <code class="literal">EST</code>, <code class="literal">MDT</code>, <code class="literal">+05</code></td>
          </tr>

          <tr>
           <td><code class="literal">Z</code></td>
           <td>Décalage horaire en secondes. Le décalage des zones à l'ouest
            de la zone UTC est négatif, et à l'est, il est positif.</td>
           <td><code class="literal">-43200</code> à <code class="literal">50400</code></td>
          </tr>

          <tr>
           <td style="text-align: center;"><em class="emphasis">Date et Heure complète</em></td>
           <td>---</td>
           <td>---</td>
          </tr>

          <tr>
           <td><code class="literal">c</code></td>
           <td>Date au format ISO 8601</td>
           <td>2004-02-12T15:19:21+00:00</td>
          </tr>

          <tr>
           <td><code class="literal">r</code></td>
           <td>Format de date <a href="http://www.faqs.org/rfcs/rfc2822" class="link external">»&nbsp;RFC 2822</a></td>
           <td>Exemple : <code class="literal">Thu, 21 Dec 2000 16:01:070200</code></td>
          </tr>

          <tr>
           <td><code class="literal">U</code></td>
           <td>Secondes depuis l'époque Unix (1er Janvier 1970,  0h00 00s GMT)</td>
           <td>Voir aussi <span class="function"><a href="function.time.php" class="function">time()</a></span></td>
          </tr>

         </tbody>
        
       </table>

<?php require('Views/footer.php'); ?>