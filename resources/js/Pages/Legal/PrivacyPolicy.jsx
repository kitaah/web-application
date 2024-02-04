import Layout from '@/Layouts/Layout';
import { usePage } from '@inertiajs/react';

export default function PrivacyPolicy() {
    const { props } = usePage();

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Politique de confidentialité</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">Politique de confidentialité</h1>
                <p className="text-lg mb-4 text-center">Publié le 19.02.24 - Mise à jour le 29.09.24</p>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Politique de protection des données</h2>
                    <p>Le ministère s’engage à ce que la collecte et le traitement de vos données effectuées à partir de ce site,
                        soient conformes au Règlement Général sur la Protection des données (RGPD)
                        et à la loi n° 78-17 du 6 janvier 1978 modifiée, relative à l'informatique, aux fichiers et aux libertés.< br/>
                        Le ministère est particulièrement très attentif à la protection des données à caractère personnel.< br/>
                        </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Exercice de vos droits</h2>
                    <p>Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation et d'opposition sur vos données.< br/>
                        Vous pouvez exercer ce droit en nous contactant <a href="https://fr.wikipedia.org/" className="font-bold">par courriel</a>.< br/>
                        Afin de pouvoir traiter votre demande, merci de bien préciser l’objet de votre demande.<br />
                        En cas d’exercice de vos droits, vous devez justifier de votre identité.<br />
                        Si vous rencontrez des difficultés dans l’exercice de vos droits, vous pouvez contacter
                        le délégué à la protection des données (DPD) du Ministère à l’adresse suivante: le-delegue-a-la-protection-des-donnees-personnelles[at]solidarite.gouv.fr< br/>
                        En cas de non-conformité relative au traitement de vos données, vous avez le droit d'introduire
                        une réclamation auprès de l’autorité de contrôle, la CNIL, 3, Place de Fontenoy TSA 80715 75334 PARIS Cedex 07.< br/></p>
                </section>
            </div>
        </Layout>
    );
};
