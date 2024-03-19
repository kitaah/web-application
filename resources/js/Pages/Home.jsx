import Articles from "@/Components/Articles";
import Avatars from "@/Components/Avatars";
import Carousel from "@/Components/Carousel";
import Layout from "@/Layouts/Layout";
import { usePage } from "@inertiajs/react";
import { Avatar } from "flowbite-react";

export default function Home() {
    const { props } = usePage();
    // Mockup des avatars
    const avatarImages = [
        { img: "/assets/avatars/avatar1.png", name: "Étienne" },
        { img: "/assets/avatars/avatar3.jpg", name: "Amélie" },
        { img: "/assets/avatars/avatar4.png", name: "Guillaume" },
        { img: "/assets/avatars/avatar5.png", name: "Marguerite" },
        { img: "/assets/avatars/avatar1.png", name: "François" },
        { img: "/assets/avatars/avatar3.jpg", name: "Catherine" },
        { img: "/assets/avatars/avatar4.png", name: "Jacques" },
        { img: "/assets/avatars/avatar5.png", name: "Élisabeth" },
        { img: "/assets/avatars/avatar1.png", name: "Thierry" },
        { img: "/assets/avatars/avatar3.jpg", name: "Élodie" },
        { img: "/assets/avatars/avatar4.png", name: "Pierre" },
        { img: "/assets/avatars/avatar5.png", name: "Sophie" },
        { img: "/assets/avatars/avatar1.png", name: "Louis" },
        { img: "/assets/avatars/avatar3.jpg", name: "Charlotte" },
        { img: "/assets/avatars/avatar4.png", name: "Philippe" },
        { img: "/assets/avatars/avatar5.png", name: "Marie" },
        { img: "/assets/avatars/avatar1.png", name: "Antoine" },
        { img: "/assets/avatars/avatar3.jpg", name: "Isabelle" },
        { img: "/assets/avatars/avatar4.png", name: "Jeanne" },
        { img: "/assets/avatars/avatar5.png", name: "Françoise" },
        { img: "/assets/avatars/avatar5.png", name: "Sébastien" },
        { img: "/assets/avatars/avatar1.png", name: "Étienne" },
        { img: "/assets/avatars/avatar3.jpg", name: "Amélie" },
        { img: "/assets/avatars/avatar4.png", name: "Guillaume" },
        { img: "/assets/avatars/avatar5.png", name: "Marguerite" },
        { img: "/assets/avatars/avatar1.png", name: "François" },
        { img: "/assets/avatars/avatar3.jpg", name: "Catherine" },
        { img: "/assets/avatars/avatar4.png", name: "Jacques" },
        { img: "/assets/avatars/avatar5.png", name: "Élisabeth" },
        { img: "/assets/avatars/avatar1.png", name: "Thierry" },
        { img: "/assets/avatars/avatar3.jpg", name: "Élodie" },
        { img: "/assets/avatars/avatar4.png", name: "Pierre" },
    ];
    const articlesData = [
        {
            date: "March 1, 2024",
            title: "First Article",
            text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.",
        },
        {
            date: "March 5, 2024",
            title: "Second Article",
            text: "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.",
        },
        // Add more articles as needed
    ];

    return (
        <Layout
        // header={
        //     <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">
        //         Accueil
        //     </h2>
        // }
        >
            {/* <div className="container mx-auto my-8">
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
            </div> */}
            <>
                {/*auth.user && auth.user.email_verified_at*/}
                <Avatars users={props.users}></Avatars>
                {/*<Avatars avatarImages={avatarImages}></Avatars>*/}
                <Carousel competition={props.competition}/>
                {/*<Carousel />*/}
                <Articles resources={props.resources} />
                {/*<Articles articles={articlesData} />*/}

            </>
        </Layout>
    );
}
