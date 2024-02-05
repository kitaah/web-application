import Layout from '@/Layouts/Layout';
import { Link, usePage } from '@inertiajs/react';

export default function Resources() {
    const { resources } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressources</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">Liste des ressources</h1>

                <section className="mb-8 text-center">
                    <h2 className="text-2xl font-bold mb-2 text-center">Consultez la liste des ressources</h2>
                    <ul className="mb-2">
                        {resources.map(({ category_name, description, id, image, name, slug, url, user_name, created_at, updated_at }) => (
                            <li key={id}>
                                <div>Titre: <strong>{name}</strong></div><br />
                                <div className="flex justify-center items-center">
                                    <img src={image} width="400" alt={name} />
                                </div>
                                <Link href={route('resource.edit', { slug: slug })} href={`/ressource/${slug}`}>
                                    <button className="m-5 px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">Voir la ressource</button>
                                </Link>
                                <div>Url: <strong>{url}</strong></div><br />
                                <div>Catégorie: <strong>{category_name}</strong></div><br />
                                <div>Posté par: <strong>{user_name}</strong></div><br />
                                <div>Posté le: <strong>{created_at}</strong></div><br />
                                <div>Mise à jour le: <strong>{updated_at}</strong></div><br />
                            </li>
                        ))}
                    </ul>
                </section>
            </div>
        </Layout>
    );
};
