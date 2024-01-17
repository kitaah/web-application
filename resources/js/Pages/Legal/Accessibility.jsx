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
                    À cette fin, il met en œuvre la stratégie et les actions suivantes.
                    Cette déclaration d’accessibilité s’applique à : https://ressources-relationnelles.fr/accueil.</p>
            </section>

            <section className="mb-8">
                <h3 className="text-2xl font-bold mb-2">1.1 État de conformité</h3>
                <p>Le site web https://ressources-relationnelles.fr/accueil est partiellement conforme avec le référentiel général d’amélioration de l’accessibilité
                    (RGAA), version 4.1, en raison des non-conformités et des dérogations énumérées ci dessous.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Directeur de publication</h2>
                <p>M. Fabrice Moreau, délégué de la Délégation à l’information et à la communication (DICOM).<br/>
                    Le ministère se réserve le droit de modifier ou de façon plus générale, d'actualiser les mentions légales
                    à tout moment et sans préavis.<br/>
                    Nous vous invitons à les consulter régulièrement.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Liens hypertextes</h2>
                <h3 className="text-2xl font-bold mb-2">Création de liens vers le site</h3>
                <p>La mise en place de lien vers le site ressources-relationnelles.fr n’est conditionnée à aucun accord préalable.</p>

                <h3 className="text-2xl font-bold mb-2">Liens vers d'autres sites</h3>
                <p>Le site peut contenir des liens hypertextes à caractère privés ou officiels ou des références à d'autres sites.< br/>
                    Leur présence ne saurait engager le ministère quant à leur contenu, qui ne saurait tenu être responsable des dommages directs ou indirects
                    résultant de la consultation de ces contenus.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Retour d’information et contact</h2>
                <p>Si vous êtes dans l'impossibilité d'accéder à un contenu, vous pouvez contacter le responsable du <site internet / application mobile />
                    afin d'être orienté vers une alternative accessible ou obtenir le contenu sous une autre forme.
                    Envoyer un message : https://solidarites.gouv.fr/contact-webmestre ;
                    Contacter : https://solidarites.gouv.fr/tous-les-contacts-utiles
                    < br/></p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Voies de recours</h2>
                <p>Vous avez signalé un défaut d'accessibilité au responsable du site internet, entravant votre accès à un contenu<br/>
                    ou à l'un des services du portail, et vous n'avez pas reçu de réponse ou la réponse obtenue ne vous satisfait pas.<br/>
                Voici les démarches
                    - Écrire un message au Défenseur des droits par l'intermédiaire du formulaire prévu à cette effet<br/>
                    - Contacter le délégué du Défenseur des droits au sein de votre région<br/>
                    - Envoyer un courrier par la poste (gratuit, ne pas mettre un timbre) à l'adresse suivante:<br/>
                    Défenseur des droits Libre réponse 71 120 75 342 Paris CEDEX 07<br/>
                </p>
            </section>
        </div>
    );
};

export default Accessibility;
