import Layout from "@/Layouts/Layout";
import { usePage } from "@inertiajs/react";

export default function Home() {
    const { props } = usePage();
    return (
        <Layout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">
                    Accueil
                </h2>
            }
        >
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">
                    Bienvenue
                </h1>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">
                        Eiusmod tempor incididunt
                    </h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">
                        Eiusmod tempor incididunt
                    </h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">
                        Eiusmod tempor incididunt
                    </h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>
                </section>
            </div>
        </Layout>
    );
}
