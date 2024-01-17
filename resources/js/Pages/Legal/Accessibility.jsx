import React from 'react';

const Accessibility = () => {
    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Accessibilité du site</h1>
            <p className="text-lg mb-4 text-center">Publié le 23.01.24 - Mise à jour le 04.08.24</p>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Déclaration d'accessibilité</h2>
                <p>Le DICOM des ministères sociaux s’engage à rendre son site « (RE)SOURCES RELATIONNELLES » accessible conformément
                    à l’article 47 de la loi n° 2005-102 du 11 février 2005.<br/>
                    À cette fin, il met en œuvre la stratégie et les actions suivantes.<br/>
                    Cette déclaration d’accessibilité s’applique à : https://ressources-relationnelles.fr/.</p>
            </section>

            <section className="mb-8">
                <h3 className="text-2xl font-bold mb-2">État de conformité</h3>
                <p>Le site web https://ressources-relationnelles.fr/ est partiellement conforme avec le référentiel général d’amélioration de l’accessibilité
                    (RGAA), version 4.1, en raison des non-conformités et des dérogations énumérées ci dessous.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Résultats des tests</h2>
                <p>L’audit de conformité réalisé par la société Koena révèle sur un audit de 10 pages, après corrections par l’équipe de développement du site que:
                    84,26% des critères RGAA sont respectés.<br />
                    Le taux moyen de conformité du service en ligne s’élève à 97%.
                    <br/></p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Contenus inaccessibles</h2>
                <h3 className="text-2xl font-bold mb-2">Non-conformités</h3>
                <p>Les contenus listés ci-dessous ne sont pas accessibles pour les raisons suivantes:< br/>
                    - Certaines listes ne sont pas suffisament bien structurées<br />
                    - Certains composants JavaScript ne sont pas compatibles avec les technologies d’assistance<br />
                    - Certaines images n'ont pas d'alternatives adaptées<br />
                    - Le code source de certaines pages contient des erreurs<br />
                    - Le parcours de navigation au clavier manque de cohérence<br />
                    </p>

                <h3 className="text-2xl font-bold mb-2">Dérogations pour charge disproportionnée</h3>
                <p>Néant</p>

                <h3 className="text-2xl font-bold mb-2">Contenus non soumis à l’obligation d’accessibilité</h3>
                <p>Certains contenus de cet espace d'administration ont été exclus de l'échantillon de vérification de conformité à l'accessibilité,
                    car ils sont destinés à un usage interne et ne sont pas accessibles au grand public.
                    Cependant, des mesures ont été prises pour garantir que cet espace d'administration reste le plus possible conforme aux normes d'accessibilité.
                </p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Établissement de cette déclaration d’accessibilité</h2>
                <p>Cette déclaration a été établie le 23/08/2024 par Koena.< br/>
                    Elle a été mise à jour le 02/11/2025 à la suite de correctifs réalisés.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Technologies utilisées pour la réalisation du site web</h2>
                <p>-  HTML, CSS, Javascript.< br/>
                    - Framework PHP Laravel.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Agents utilisateurs, technologies d’assistance et outils utilisés pour vérifier l’accessibilité</h2>
                <p>Les tests des pages web ont été effectués avec les combinaisons de navigateurs web et lecteurs d’écran suivants:< br/>
                    - Agent utilisateur - Technologie d’assistance Firefox et NVDA<br />
                    - Agent utilisateur Firefox - Technologie d’assistance JAWS<br />
                    - Agent utilisateur Safari - Technologie d’assistance VoiceOver<br />
                    < br/></p>
                <p>Les outils de vérification du code suivants ont été employés lors de l'évaluation:< br/>
                    - Inspecteur de code du navigateur<br />
                    - Color Contrast Analyser<br />
                    - Extension HeadingMaps<br />
                    - Extension Wave<br />
                    - Validateur du W3C
                    < br/></p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Pages du site ayant fait l’objet de la vérification de conformité</h2>
                <p>L’échantillon des pages du site ayant fait l’objet d’une vérification de conformité est le suivant:< br/>
                    - Page d'accueil <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/</a><br/>
                    - Accessibilité <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/accessibilite</a><br/>
                    - Mentions légales <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/mentions-legales</a><br/>
                    - Politique de confidentialité <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/politique-de-confidentialite</a><br/>
                    - Gestion de cookies <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/gestion-de-cookies</a><br/>
                    - Listing des ressources <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/ressources</a><br/>
                    - Page ressource "L'évolution du handisport en Bretagne" <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/ressource/levolution-du-handisport-en-bretagne</a><br/>
                    - Page ressource "Le bien-être au travail" <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/ressource/le-bien-etre-au-travail</a><br/>
                    - Listing des associations <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/associations</a><br/>
                    - Page association "Solidarité bordelaise" <a href="https://fr.wikipedia.org/" className="font-bold">https://ressources-relationnelles.fr/association/solidarite-bordelaise</a><br/>
                </p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Retour d’information et contact</h2>
                <p>Si vous êtes dans l'impossibilité d'accéder à un contenu, vous pouvez contacter le responsable du site internet et de l'application mobile pour être orienté vers
                    une alternative accessible ou obtenir le contenu sous une forme différente.< br/>
                    - <a href="https://fr.wikipedia.org/" className="font-bold">Envoyer un message</a>< br/>
                    - <a href="https://fr.wikipedia.org/" className="font-bold">Contacter la DICOM</a>
                </p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Voie de recours</h2>
                <p>Cette procédure est à utiliser dans le cas suivant.< br/>
                    Vous avez signalé au responsable du site internet un défaut d’accessibilité
                    qui vous empêche d’accéder à un contenu du site et vous n’avez pas reçu de réponse ou que la réponse obtenue n'a pas été satisfaisante.< br/>
                    - Écrire un message au Défenseur des droits via le formulaire prévu à cet effet< br/>
                    - Contacter le délégué du Défenseur des droits dans votre région< br/>
                    - Envoyer un courrier par la poste (gratuit, ne pas mettre de timbre) à l'adresse suivant: Défenseur des droits Libre réponse 71 120 75 342 Paris CEDEX 07< br/>
                </p>
            </section>
        </div>
    );
};

export default Accessibility;
