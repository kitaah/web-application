import React from 'react';

const Disclaimer = () => {
    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Mentions légales</h1>
            <p className="text-lg mb-4 text-center">Publié le 12.01.24 - Mise à jour le 29.06.24</p>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Information éditeur</h2>
                <p>Les principaux services du ministère participent à la gestion et à l’amélioration du site ressources-relationnelles.fr.<br/>
                    Le suivi éditorial, graphique et technique est pris en charge par le cabinet du ministre et par la délégation à l’information et à la communication (DICOM).<br/>
                    14 avenue Duquesne - 75350 Paris 07 SP.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Informations prestataires</h2>
                <p>L'hébergement est assuré par la société <a href="https://fr.wikipedia.org/" className="font-bold">OVHCLoud</a>.<br/>
                    Le développement est assuré par la société <a href="https://fr.wikipedia.org/" className="font-bold">MNA Coding</a>.</p>
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
                <h2 className="text-2xl font-bold mb-2">Propriété intellectuelle</h2>
                <p>L’intégralité des pages, textes, images et graphiques présentent sur le site sont protégés par droit d’auteur ou d’autres droits de protection prévus par la loi.< br/>
                    Sauf accord explicite, aucune licence n’est accordée au titre du présent site.< br/>
                    Il est interdit de copier, diffuser ou modifier tout ou partie du contenu du présent site à des fins commerciales ou autre et d’en permettre l’accès à des tiers sans autorisation préalable écrite.< br/>
                    Nous attirons l’attention sur le fait que le site contient des images pouvant être soumises au droit d’auteur de tiers.</p>
            </section>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2">Responsabilités relatives aux contenus</h2>
                <h3 className="text-2xl font-bold mb-2">Contenus du site</h3>
                <p>Malgré tout le soin apporté par nos équipes éditoriales et techniques à la rédaction,
                    des erreurs typographiques ou des inexactitudes techniques ne peuvent être exclues.<br/>
                    Le ministère de la Santé et de la Prévention se réserve le droit de les corriger à tout moment dès qu’elles sont portées à sa connaissance.<br/>
                    Les informations présentent sur le site sont susceptibles de faire l’objet de mise à jour à tout moment.</p>
                <h3 className="text-2xl font-bold mb-2">Clause de responsabilité</h3>
                <p>Bien que nous apportions une attention particulière à la transcription des textes officiels
                    et à la vérification des contenus et des informations, les éléments publiés ne peuvent en aucun cas
                    prétendre à une exactitude totale et n'engagent pas la responsabilité du ministère.</p>
            </section>
        </div>
    );
};

export default Disclaimer;
