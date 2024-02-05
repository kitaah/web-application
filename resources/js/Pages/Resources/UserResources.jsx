import Layout from '@/Layouts/Layout';
import {Link, usePage} from '@inertiajs/react';
import NavLink from "@/Components/NavLink.jsx";

export default function UserResources() {
    const { userResources } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Mes ressources</h2>}>
            <div className="container mx-auto my-8">
                <section className="mb-8">
                    <div className="container mx-auto my-8">
                        <h1 className="text-4xl font-bold mb-4 text-center">Mes ressources</h1>

                        <div className="text-3xl font-bold mb-4 text-center">Listing de vos ressources</div>

                        <div className="text-center">
                            <button className="m-5 px-6 py-2 mt-4 text-white bg-green-500 rounded-md focus:outline-none">
                                <Link href={route('resource.create')} active={route().current('resource.create')}>
                                    Ajouter une ressource
                                </Link>
                            </button>
                        </div>

                        <section className="mb-8">
                            <ul className="mb-2">
                                {userResources.map(({ category_name, id, name, status, slug, created_at, updated_at, is_validated }) => (
                                    <div key={id}>
                                        <div>
                                            <div className="relative overflow-x-auto">
                                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" className="px-6 py-3">
                                                            Nom
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Catégorie
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Création
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modification
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Statut
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Validée
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Voir
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modifier la ressource
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modifier l'image
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {name}
                                                        </th>
                                                        <td className="px-6 py-4">
                                                            {category_name}
                                                        </td>
                                                        <th scope="col" className="px-6 py-3">
                                                            {created_at}
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            {updated_at}
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            {status}
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            {is_validated ? 'Oui' : 'Non'}
                                                        </th>
                                                        <td className="px-6 py-4">
                                                            {status === 'En attente' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none">Indisponible</button>
                                                            ) : status === 'Suspendue' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-red-500 rounded-md focus:outline-none">Suspendue</button>
                                                            ) : (
                                                                <Link href={route('resources.show', { slug: slug })}>
                                                                    <button className="m-5 px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                                                        Voir la ressource
                                                                    </button>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status === 'En attente' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none">Indisponible</button>
                                                            ) : status === 'Suspendue' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-red-500 rounded-md focus:outline-none">Non valable</button>
                                                            ) : (
                                                                <Link href={route('resource.edit', { slug: slug })}>
                                                                    <button className="m-5 px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none">
                                                                        Modifier la ressource
                                                                    </button>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status === 'En attente' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none">Indisponible</button>
                                                            ) : status === 'Suspendue' ? (
                                                                <button className="m-5 px-6 py-2 mx-5 text-white bg-red-500 rounded-md focus:outline-none">Non valable</button>
                                                            ) : (
                                                                <Link href={route('image.edit', { slug: slug })}>
                                                                    <button className="m-5 px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none">
                                                                        Modifier l'image
                                                                    </button>
                                                                </Link>
                                                            )}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </ul>
                        </section>
                    </div>
                </section>
            </div>
        </Layout>
    );
}
