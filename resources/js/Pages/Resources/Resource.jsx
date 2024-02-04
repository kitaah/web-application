import Layout from '@/Layouts/Layout';
import { usePage } from '@inertiajs/react';

export default function Resource() {
    const { resource } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressource</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">{resource.name}</h1>

                <section className="mb-8 text-center">
                    <div className="flex justify-center items-center">
                        <img src={resource.image} width="400" alt={resource.name} />
                    </div>
                    <div>Url : <strong>{resource.url}</strong></div><br />
                    <div>Description : <strong>{resource.description}</strong></div><br />
                    <div>Catégorie : <strong>{resource.category_name}</strong></div><br />
                    <div>Posté par : <strong>{resource.user_name}</strong></div><br />
                    <div>Posté le : <strong>{resource.created_at}</strong></div><br />
                    <div>Mise à jour le : <strong>{resource.updated_at}</strong></div><br />
                </section>
            </div>
        </Layout>
    );
};
